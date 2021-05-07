@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Plugins</h2>
            <div>{{ count($plugins) }} found.</div>
            <table class="table table-striped">
                <tr class="table-header">
                    <th>Name</th>
                    <th>Install Path</th>
                    <th>Commit</th>
                    <th>Tag</th>
                    <th>Version</th>
                </tr>
                @foreach ($plugins as $plugin)
                    <tr>
                        <td class="data-column"><a href="/plugins/{{ $plugin->id }}">{{ $plugin->title }}</a></td>
                        <td class="data-column">{{ $plugin->install_path }}</td>
                        @foreach($plugin->commits as $key=>$commit)
                            @if($key)
                                </tr><tr><td></td><td></td>
                            @endif
                            <td class="commit commit-id">
                                <a href="/commits/{{ $commit->id }}">{{ substr($commit->commit_id,0,10).'...' }}</a>
                            </td>
                            <td class="commit">{{ $commit->tag }} </td>
                            <td class="commit">{{ $commit->version }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
            <div>
                <br>
                <a href="/plugins/create" class="button is-text btn btn-primary mb-3">Add new Plugin</a>
            </div>
        </div>
    </div>
@endsection
