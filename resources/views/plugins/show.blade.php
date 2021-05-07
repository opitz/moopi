@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Plugin</h2>

            <table class="table">
                <tr>
                    <td class="label">Title</td>
                    <td class="data">{{ $plugin->title }}</td>
                </tr>
                <tr>
                    <td class="label">Description</td>
                    <td class="data">{{ $plugin->description }}</td>
                </tr>
                <tr>
                    <td class="label">Repository</td>
                    <td class="data">{{ $plugin->github_url }}</td>
                </tr>
                <tr>
                    <td class="label">Developer</td>
                    <td class="data">{{ $plugin->developer }}</td>
                </tr>
                <tr>
                    <td class="label">Path</td>
                    <td class="data">{{ $plugin->install_path }}</td>
                </tr>
                <tr>
                    <td class="label">Wiki URL</td>
                    <td class="data"><a href="{{ $plugin->wiki_url }}" target="_blank">{{ $plugin->wiki_url }}</td>
                </tr>
                <tr>
                    <td class="label">Category</td>
                    <td class="data">{{ $plugin->category_id }}</td>
                </tr>
                <tr>
                    <td class="label">Requested by</td>
                    <td class="data">{{ $plugin->requested_by }}</td>
                </tr>
                <tr>
                    <td class="label">Requester</td>
                    <td class="data">{{ $plugin->requester }}</td>
                </tr>
                <tr>
                    <td class="label">Year Added</td>
                    <td class="data">{{ $plugin->year_added }}</td>
                </tr>

            </table>

            @if($plugin->commits->count())
                <table class="table table-striped">
                    <tr class="header">
                        <th>Commit</th>
                        <th>Collection</th>
                        <th>Moodle Branch</th>
                    </tr>
                    @foreach($plugin->commits as $commit)
                        <tr>
                            <td class="data-column" valign="top">
                                <a href="/commits/{{ $commit->id }}">{{ $commit->commit_id }}</a>
                            </td>
                            @foreach($commit->collections as $key => $collection)
                                @if($key)
                                    </tr><tr><td></td>
                                @endif
                                <td class="data-column">
                                    <a href="/collections/{{ $collection->id }}">
                                        {{ $collection->name }}
                                    </a>
                                </td>
                                <td>{{ $collection->branch->name }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            @endif

            <div class="control">
                <a href="/plugins/edit/{{ $plugin->id }}" class="button is-text btn btn-primary mb-3">Edit</a>
                <a href="/commits/create/{{ $plugin->id }}" class="button is-text btn btn-primary mb-3">New Commit</a>
                <a href="/plugins" class="button is-text btn btn-primary mb-3">Back</a>
            </div>

        </div>
    </div>
@endsection
