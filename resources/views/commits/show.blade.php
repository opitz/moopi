@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Commit</h2>

            <table class="table">
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
            </table>
        </div>
    </div>
@endsection
