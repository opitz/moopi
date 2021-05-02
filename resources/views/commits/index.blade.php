@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Commits @if(isset($plugin)) of Plugin <a href="/plugin/{{ $plugin->id }}">{{ $plugin->title }}</a>@endif</h2>
            <table>
                <tr class="table-header">
                    <th>Plugin</th>
                    <th>Path</th>
                    <th>Commit ID</th>
                </tr>
                @foreach ($commits as $commit)
                    <tr>
                        <td class="data-column">{{ $commit->plugin->title }}</td>
                        <td class="data-column">{{ $commit->plugin->install_path }}</td>
                        <td class="data-column">{{ $commit->commit_id }}</td>
                    </tr>
                @endforeach
            </table>
            @foreach ($commits as $commit)
                <record>
                    <div>
                        <a href="/commits/{{ $commit->id }}">ID : {{ $commit->id }} - {{ $commit->tag }}</a>
                    </div>
                </record>
            @endforeach

        </div>
    </div>

@endsection
