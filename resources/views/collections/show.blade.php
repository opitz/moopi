@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Collection</h2>

            <table class="table">
                <tr>
                    <td class="label" width="10%">Name</td>
                    <td class="data">{{ $collection->name }}</td>
                </tr>
                <tr>
                    <td class="label" width="10%">Moodle Branch</td>
                    <td class="data">{{ $collection->branch->name }}</td>
                </tr>
                <tr>
                    <td class="label" width="10%">Plugins</td>
                    <td class="data">
                        <table>
                            <tr>
                                <th>Plugin</th>
                                <th>Path</th>
                                <th>Commit ID</th>
                            </tr>
                            @foreach($collection->commits as $commit)
                                <tr>
                                    <td class="data-column"><a href="/plugins/{{ $commit->plugin->id }}">{{ $commit->plugin->title }}</a></td>
                                    <td class="data-column"><a href="/plugins/{{ $commit->plugin->id }}">{{ $commit->plugin->install_path }}</a></td>
                                    <td class="data-column"><a href="/commits/{{ $commit->id }}">{{ $commit->commit_id }}</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            </table>
            <div>
                <br>
                <a href="/collections/export/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Export Collection</a>
                <a href="/collections/delete/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Delete Collection</a>
            </div>
        </div>
    </div>
@endsection
