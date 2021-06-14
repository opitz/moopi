<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Collection;
use App\Models\Plugin;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('collections.index', [
            'collections' => Collection::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::all();
        return view('collections.create',['branches' => $branches]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        request()->validate([
            'name' => 'required',
            'branch_id' => 'required'
        ]);

        $collection = Collection::create([
           'name' =>  request('name'),
            'branch_id' => request('branch_id'),
            'description' => request('description'),
        ]);
/*
        $collection = new Collection();
        $collection->name = request('name');
        $collection->moodle_branch = request('moodle_branch');
        $collection->save();
*/
        return redirect('/collections');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('collections.show', [
            'collection' => Collection::with('commits')->find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        $branches = Branch::all();
        return view('collections.edit', [
            'collection' => $collection,
            'branches' => $branches
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection)
    {
        $collection->name = request('name');
        $collection->branch_id = request('branch_id');
        $collection->description = request('description');
        // Put all id's of related commits into an array and use it to sync all values
        $commit_ids = [];
        foreach ($collection->plugins as $plugin) {
            if($cid = request("commit-$plugin->id")) {
                $commit_ids[] = $cid;
            }
        }
        $collection->commits()->sync($commit_ids);

        // Detach all marked plugins and their commits
        $marked4detachment = request("detach");
        if (isset($marked4detachment) && count($marked4detachment)) {
            $collection->commits()->detach($marked4detachment);
            $collection->plugins()->detach($marked4detachment);
        }

        $collection->save();

        return redirect("/collections/$collection->id");
    }

    public function add_plugins(Request $request, Collection $collection)
    {
        $collection->name = request('name');
        $collection->branch_id = request('branch_id');

        // Attach all marked plugins and their commits
        $marked4attachment = request("attach");
        if (isset($marked4attachment) && count($marked4attachment)) {
            $collection->plugins()->attach($marked4attachment);
            $collection->commits()->attach($marked4attachment);
        }

//        ddd($collection);
        $collection->save();

        return redirect("/collections/$collection->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        Collection::find($collection->id)->delete();
        return redirect('/collections');
    }

    /**
     * Replicate the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function replicate($id)
    {
        $collection = Collection::with('commits')->find($id);
        $newcollection = $collection->replicate();
        $newcollection->name = $newcollection->name.' (copy)';
        $newcollection->save();
        // Clone the plugins and commits as well
        foreach ($collection->plugins as $plugin) {
            $newcollection->plugins()->attach($plugin);
        }
        foreach ($collection->commits as $commit) {
            $newcollection->commits()->attach($commit);
        }


        return redirect("/collections/edit/$newcollection->id");
    }

    /**
     * Detach all selected commits.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function detach(Collection $collection)
    {
        $commit_ids = array();
        $request = request("testbox");
        ddd($request);
        foreach ($collection->commits as $commit) {
            $request = request("delete-$commit->id");
            echo '==>'.$request;
            echo "<br>";
        }
        die('argh..');

        return redirect("/collections/$newcollection->id");
    }

    /**
     * Add new commits
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function add0(Collection $collection)
    {
        // Build an array of plugin github URLs to check against
        $used_plugins = [];
        $unused_plugins = [];
        foreach($collection->plugins as $plugin) {
            $used_plugins[] = $plugin->repository_url;
        }

        $plugins = Plugin::all();
        foreach ($plugins as $plugin) {
            // Check if the plugin is already used
            if(!in_array($plugin->repository_url,$used_plugins)) {
                $unused_plugins[] = $plugin;
            }
        }

//        ddd($unused_plugins);

        $branches = Branch::all();
        return view('collections.add', [
            'collection' => $collection,
            'plugins' => $unused_plugins,
            'branches' => $branches
        ]);
    }
    public function add(Collection $collection)
    {
        $unused_plugins = [];
        $plugins = Plugin::all();
        foreach ($plugins as $plugin) {
            // Check if the plugin is already used
            if(!$collection->hasPlugin($plugin->id)) {
                $unused_plugins[] = $plugin;
            }
        }

//        ddd($unused_plugins);

        $branches = Branch::all();
        return view('collections.add', [
            'collection' => $collection,
            'plugins' => $unused_plugins,
            'branches' => $branches
        ]);
    }
}
