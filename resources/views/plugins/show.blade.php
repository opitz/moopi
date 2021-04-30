@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Plugin</h2>

            <table class="table">
                <tr>
                    <td class="label" width="10%">Title</td>
                    <td class="data">{{ $plugin->title }}</td>
                </tr>
                <tr>
                    <td class="label">GitHub</td>
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
                    <td class="label">Description</td>
                    <td class="data">{{ $plugin->description }}</td>
                </tr>
                @if($plugin->commits->count())
                    <tr>
                        <td class="label">Commits:</td>
                        <td class="data">
                            <ul>
                                @foreach($plugin->commits as $commit)
                                    <li><a href="/commits/{{ $commit->id }}">{{ $commit->commit_id }}</a></li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endif

            </table>

            <div class="control">
                <a href="/plugins/edit/{{ $plugin->id }}" class="button is-text btn btn-primary mb-3">Edit</a>
                <a href="/commits/create/{{ $plugin->id }}" class="button is-text btn btn-primary mb-3">New Commit</a>
                <a href="/plugins" class="button is-text btn btn-primary mb-3">Back</a>
            </div>

        </div>
    </div>
@endsection
