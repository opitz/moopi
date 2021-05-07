@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <form method="POST" action="/collections/add_plugins/{{ $collection->id }}">
                @csrf
                @method('PUT')

                <table class="table">
                    <tr class="titlearea">
                        <td class="title">Collection</td>
                        <td class="title-actions">
                            <a href="/collections/duplicate/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Duplicate</a>
                            <a href="/collections/add/{{ $collection->id }}" class="button is-text btn btn-primary mb-3 disabled">Add</a>
                            <a href="/collections/edit/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Edit</a>
                            <a href="/collections/export/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Export</a>
                            <a href="/collections/delete/{{ $collection->id }}" class="button is-text btn btn-danger mb-3">Delete</a>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Name</td>
                        <td><input class="form-control" type="text" name="name" id="name" value="{{ $collection->name }}"></td>
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
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">No. of Plugins</td>
                        <td id="plugins_number" class="data">{{ count($plugins) }}</td>
                        <td class="data">
                            <input type="text" id="filter" onkeyup="filter_path()" placeholder="Filter install path by...">
                        </td>
                    </tr>
                </table>

                <table class="table">
                    <tr>
                        <th>Plugin</th>
                        <th>Path</th>
                        <th>Commit ID (Tag)</th>
                        <th>Add selected</th>
                    </tr>
                    @foreach($plugins as $plugin)
                        <tr>
                            <td class="data-column">
                                <a href="/plugins/{{ $plugin->id }}">{{ $plugin->title }}</a>
                            </td>
                            <td class="data-column install_path">
                                <a href="/plugins/{{ $plugin->id }}">{{ $plugin->install_path }}</a>
                            </td>

                            <td>
                                <select name="plugin-{{ $plugin->id }}" id="plugin-{{ $plugin->id }}">
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
                            <td class="mark4attachment">
                                <input type="checkbox" name="attach[]" id="{{ $plugin->id }}" value="{{ $plugin->id }}">
                            </td>
                        </tr>
                    @endforeach
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
