@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <form method="POST" action="/collections/{{ $collection->id }}">
                @csrf
                @method('PUT')

                <table class="table">
                    <tr class="titlearea">
                        <td class="title">Collection</td>
                        <td class="title-actions">
                            <a href="/collections/duplicate/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Duplicate</a>
                            <a href="/collections/add/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Add</a>
                            <a href="/collections/edit/{{ $collection->id }}" class="button is-text btn btn-primary mb-3 disabled">Edit</a>
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
                        <th>Commit ID (Tag)</th>
                        <th>Delete selected</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($collection->commits as $commit)
                        <tr>
                            <td class="data-column"><a href="/plugins/{{ $commit->plugin->id }}">{{ $commit->plugin->title }}</a></td>
                            <td class="data-column install_path"><a href="/plugins/{{ $commit->plugin->id }}">{{ $commit->plugin->install_path }}</a></td>

                            <td>
                                <select name="commit-{{ $commit->id }}" id="commit-{{ $commit->id }}">
                                    @foreach($commit->plugin->commits as $pcommit)
                                        <option value="{{ $pcommit->id }}" {{ ($pcommit->id == $commit->id ? 'selected':'') }}>
                                            {{ substr($pcommit->commit_id,0,10).'...' }}
                                            @if($pcommit->tag != '')
                                                ({{ $pcommit->tag }})
                                            @endif

                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="mark4deletion">
                                <input type="checkbox" name="detach[]" id="{{ $commit->id }}" value="{{ $commit->id }}">
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
