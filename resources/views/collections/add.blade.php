@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <div id="filter_input">
                <input type="text" id="filter" onkeyup="filter()" placeholder="Filter by...">
            </div>
            <form method="POST" action="/collections/add_plugins/{{ $collection->id }}">
                @csrf
                @method('PUT')

                <table class="table">
                    <tr class="titlearea">
                        <td id="title" class="title">Collection</td>
                        <td class="title-actions">
                            <a href="/collections/duplicate/{{ $collection->id }}" class="button is-text btn btn-sm">Duplicate</a>
                            <a href="/collections/add/{{ $collection->id }}" class="button is-text btn btn-sm disabled">Add</a>
                            <a href="/collections/edit/{{ $collection->id }}" class="button is-text btn btn-sm">Edit</a>
                            <a href="/collections/export/{{ $collection->id }}" class="button is-text btn btn-sm">Export</a>
                            <a href="/collections/delete/{{ $collection->id }}" class="button is-text btn btn-sm">Delete</a>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Name</td>
                        <td><input class="form-control" type="text" name="name" id="name" value="{{ $collection->name }}"></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label" for="branch">Moodle Branch</td>
                        <td>
                            <select name="branch_id" id="branch_id">
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ ($branch->id == $collection->branch->id ? 'selected':'') }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="label">Plugins</td>
                        <td id="plugins_number" class="data">{{ count($plugins) }}</td>
                    </tr>
                </table>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Plugin</th>
                            <th>Path</th>
                            <th>Commit ID (Tag)</th>
                            <th>Add selected</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plugins as $plugin)
                            <tr class="plugin">
                                <td class="data-column">
                                    <a href="/plugins/{{ $plugin->id }}">{{ $plugin->title }}</a>
                                </td>
                                <td class="data-column install_path">
                                    <a href="/plugins/{{ $plugin->id }}">{{ $plugin->install_path }}</a>
                                </td>

                                <td>
                                    <select name="plugin-{{ $plugin->id }}" id="plugin-{{ $plugin->id }}">
                                        <option value="" >No specific commit</option>
                                        @foreach($plugin->commits as $commit)
                                            <option value="{{ $commit->id }}">
                                                {{ substr($commit->commit_id,0,10).'...' }}
                                                @if($commit->tag != '')
                                                    ({{ $commit->tag }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="mark4attachment" align="center">
                                    <input type="checkbox" name="attach[]" id="{{ $plugin->id }}" value="{{ $plugin->id }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link btn btn-primary mb-3" type="submit">Submit</button>
                        <a href="/collections/{{ $collection->id }}" class="button0 is-text btn mb-3">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
