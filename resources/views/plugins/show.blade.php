@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td id="title" class="title">Plugin</td>
                    <td class="title-actions">
                        <a href="/plugins/edit/{{ $plugin->id }}" class="button is-text btn btn-sm">Edit</a>
                        <a href="/commits/create/{{ $plugin->id }}" class="button is-text btn btn-sm">New Commit</a>
                        <a href="/plugins" class="button is-text btn btn-sm">Back</a>
                        <a
                            href="/plugins/delete/{{ $plugin->id }}"
                            class="button is-text btn btn-sm btn-danger"
                            onclick="return confirm('Really deleting the plugin \'{{ $plugin->title }}\' and all its commits?')"
                        >
                            Delete
                        </a>
                    </td>
                    <td>
                        @if($plugin->public)
                            public
                        @endif
                    </td>
                </tr>

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
                    <td class="data">{{ $plugin->repository_url }}</td>
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
                    <td class="label">Information URL</td>
                    <td class="data"><a href="{{ $plugin->info_url }}" target="_blank">{{ $plugin->info_url }}</td>
                </tr>
                <tr>
                    <td class="label">Plugin URL</td>
                    <td class="data"><a href="{{ $plugin->plugin_url }}" target="_blank">{{ $plugin->plugin_url }}</td>
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
                        <th>Tag</th>
                        <th>Collection</th>
                        <th>Moodle Branch</th>
                    </tr>
                    @foreach($plugin->commits as $commit)
                        <tr>
                            <td class="data-column" valign="top">
                                <a href="/commits/{{ $commit->id }}">{{ $commit->commit_id }}</a>
                            </td>
                            <td>{{ $commit->tag }}</td>
                            @foreach($commit->collections as $key => $collection)
                                @if($key)
                                    </tr><tr><td></td><td></td>
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
        </div>
    </div>
@endsection
