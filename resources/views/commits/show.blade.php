@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td class="title">Commit</td>
                    <td class="title-actions">
                        <a href="/commits/add/{{ $commit->id }}" class="button is-text btn-sm">Add</a>
                        <a href="/commits/edit/{{ $commit->id }}" class="button is-text btn-sm">Edit</a>
                        <a
                            href="/commits/delete/{{ $commit->id }}"
                            class="button is-text btn-sm btn-danger mb-3"
                            onclick="return confirm('Really deleting the commit ID \'{{ substr($commit->commit_id,0,10).'...' }}\'?')"
                        >
                            Delete
                        </a>
                    </td>
                    <td></td>
                </tr>

                <tr>
                    <td class="label" width="10%">Plugin</td>
                    <td class="data"><a href="/plugins/{{ $commit->plugin->id }}">{{ $commit->plugin->title }}</a></td>
                </tr>
                <tr>
                    <td class="label">Commit ID</td>
                    <td class="data">{{ $commit->commit_id }}</td>
                </tr>
                <tr>
                    <td class="label">Tag</td>
                    <td class="data">{{ $commit->tag }}</td>
                </tr>
                <tr>
                    <td class="label">Version</td>
                    <td class="data">{{ $commit->version }}</td>
                </tr>
                <tr>
                    <td class="label">Used in</td>
                    <td>
                        <table class="table table-striped">
                            <tr class="header">
                                <th>Collection</th>
                                <th>Moodle Branch</th>
                            </tr>
                            @foreach($commit->collections->sortBy('name') as $collection)
                                <tr>
                                    <td><a href="/collections/{{ $collection->id }}">{{ $collection->name }}</a></td>
                                    <td>{{ $collection->branch->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>

            </table>
        </div>
    </div>
@endsection
