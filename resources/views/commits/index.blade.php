@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td id="title" class="title">Commits</td>
                    <td class="title-actions">
                        <a href="/commits/create" class="button is-text btn btn-primary mb-0">Add new Commit</a>
                        <a
                            id="delete-selected-commits"
                            href="/commits/delete_selected"
                            class="button is-text btn btn-danger mb-0 disabled"
                            onclick="return confirm('Really delete selected commits?')"
                            disabled
                        >
                            Delete
                        </a>
                    </td>
                </tr>
            </table>


            <table class="table">
                <thead>
                    <tr class="table-header">
                        <th>Plugin</th>
                        <th>Path</th>
                        <th>Commit ID</th>
                        <th>Tag</th>
                        <th>Collection</th>
                        <th>Delete selected</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commits as $commit)
                        <tr scope="row">
                            <td class="data-column">{{ $commit->plugin->title }}</td>
                            <td class="data-column">{{ $commit->plugin->install_path }}</td>
                            <td class="data-column w150">
                                <a href="/commits/{{ $commit->id }}">{{ substr($commit->commit_id,0,8).'...' }}</a>
                            </td>
                            <td class="data-column">{{ $commit->tag }}</td>
                            <td>
                                <table>
                                    @foreach($commit->collections as $collection)
                                        <tr>
                                            <td class="data-column"><a href="/collections/{{ $collection->id }}">{{ $collection->name }}</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                            <td class="mark4deletion" align="center">
                                <input type="checkbox" name="detach[]" id="{{ $commit->id }}" value="{{ $commit->id }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
