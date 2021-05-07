@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td class="title">Plugins</td>
                    <td class="title-actions">
                        <a href="/plugins/create" class="button is-text btn btn-primary mb-3">Add new Plugin</a>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="label">No. of Plugins</td>
                    <td id="plugins_number" class="data">{{ count($plugins) }}</td>
                    <td class="data">
                        <input type="text" id="filter" onkeyup="filter_path()" placeholder="Filter install path by...">
                    </td>
                </tr>
            </table>


            <table class="table table-striped">
                <tr class="table-header">
                    <th>Name</th>
                    <th>Install Path</th>
                    <th>Repository</th>
                    <th></th>
                </tr>
                @foreach ($plugins as $plugin)
                    <tr>
                        <td class="data-column"><a href="/plugins/{{ $plugin->id }}">{{ $plugin->title }}</a></td>
                        <td class="data-column install_path"><a href="/plugins/{{ $plugin->id }}">{{ $plugin->install_path }}</a></td>
                        <td class="data-column">{{ $plugin->repository_url }}</td>
                        <td><a href="/plugins/edit/{{ $plugin->id }}" class="button is-text btn btn-primary mb-0">Edit</a></td>
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
