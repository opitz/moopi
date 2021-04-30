<?php

namespace App\Http\Controllers;

use App\Models\Plugin;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('plugins.index', [
            'plugins' => Plugin::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plugins.create');
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
           'title' => 'required',
           'github_url' => 'required',
           'install_path' => 'required'
        ]);
        // Clean up
        $plugin = new Plugin();
        $plugin->title = request('title');
        $plugin->github_url = request('github_url');
        $plugin->developer = request('developer');
        $plugin->install_path = request('install_path');
        $plugin->wiki_url = request('wiki_url');
        $plugin->category_id = request('category_id');
        $plugin->description = request('description');
        $plugin->save();

        return redirect('/plugins');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function show(Plugin $plugin) {
        return view('plugins.show', [
            'plugin' => $plugin
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function edit(Plugin $plugin)
    {
        return view('plugins.edit', [
            'plugin' => $plugin
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function update(Plugin $plugin)
    {
        // Validation
        request()->validate([
            'title' => 'required',
            'github_url' => 'required',
            'install_path' => 'required'
        ]);
        $plugin->title = request('title');
        $plugin->github_url = request('github_url');
        $plugin->developer = request('developer');
        $plugin->install_path = request('install_path');
        $plugin->wiki_url = request('wiki_url');
        $plugin->category_id = request('category_id');
        $plugin->description = request('description');
        $plugin->save();

        return redirect("/plugins/$plugin->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plugin $plugin)
    {
        //
    }
}
