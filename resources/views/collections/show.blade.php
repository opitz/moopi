@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td class="title">Collection</td>
                    <td class="title-actions">
                        <a href="/collections/duplicate/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Duplicate</a>
                        <a href="/collections/add/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Add</a>
                        <a href="/collections/edit/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Edit</a>
                        <a href="/collections/export/{{ $collection->id }}" class="button is-text btn btn-success mb-3">Export</a>
                    </td>
                    <td></td>
                </tr>

                <tr>
                    <td class="label">Name</td>
                    <td class="data">{{ $collection->name }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="label">Moodle Branch</td>
                    <td class="data">{{ $collection->branch->name }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="label">No. of Plugins</td>
                    <td id="plugins_number" class="data">{{ $collection->commits()->count() }}</td>
                    <td class="data">
                        <input type="text" id="filter" onkeyup="filter_path()" placeholder="Filter install path by...">
                    </td>
                </tr>
            </table>

            <table class="table">
                <thead>
                <tr>
                    <th>Plugin</th>
                    <th>Path</th>
                    <th>Commit ID</th>
                    <th>Tag</th>
                </tr>
                </thead>
                <tbody>
                @foreach($collection->commits as $commit)
                    <tr class="commit-row">
                        <td class="data-column"><a href="/plugins/{{ $commit->plugin->id }}">{{ $commit->plugin->title }}</a></td>
                        <td class="data-column install_path"><a href="/plugins/{{ $commit->plugin->id }}">{{ $commit->plugin->install_path }}</a></td>
                        <td class="data-column"><a href="/commits/{{ $commit->id }}">{{ substr($commit->commit_id,0,10).'...' }}</a></td>
                        <td class="data-column">{{ $commit->tag }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
