@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Commits @if(isset($plugin)) of Plugin <a href="/plugin/{{ $plugin->id }}">{{ $plugin->title }}</a>@endif</h2>
            <table class="table table-striped">
                <tr class="table-header">
                    <th>Plugin</th>
                    <th>Path</th>
                    <th>Commit ID</th>
                    <th>Tag</th>
                    <th>Collection</th>
                </tr>
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
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
