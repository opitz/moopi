<?php

namespace App\Http\Controllers;

use App\Models\Plugin;
use App\Models\Commit;
use Illuminate\Http\Request;

class CommitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('commits.index', [
            'commits' => Commit::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($plugin_id)
    {
        return view('commits.create', [
            'plugin' => Plugin::find($plugin_id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $commit = new Commit();
        $plugin_id = request('plugin_id');
//        $return_path = ""$plugin_id
//        ddd($plugin_id);
        $commit->plugin_id = $plugin_id;
        $commit->commit_id = request('commit_id');
        $commit->tag = request('tag');
        $commit->version = request('version');
        $commit->save();
        return redirect("/plugins/$commit->plugin_id");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commit  $commit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('commits.show', [
            'commit' => Commit::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commit  $commit
     * @return \Illuminate\Http\Response
     */
    public function edit(Commit $commit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commit  $commit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commit $commit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commit  $commit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commit $commit)
    {
        //
    }
}
