@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="filter_input">
            <input type="text" id="filter" onkeyup="filter()" placeholder="Filter by...">
        </div>
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td id="title" class="title">Plugins</td>
                    <td class="title-actions">
                        <div id="toggle_description" class="button is-text btn btn-sm hide_description">Hide Description</div>
                        &nbsp;
                        <a href="/plugins/create" class="button is-text btn btn-sm">Add new Plugin</a>
                        <a href="/plugins/import" class="button is-text btn btn-sm">Import Plugins</a>
                        <a href="/plugins/export" class="button is-text btn btn-sm">Export Plugins</a>
                    </td>
                    <td class="label">Plugins</td>
                    <td id="plugins_number" class="data">{{ count($plugins) }}</td>
                </tr>
            </table>


            <table id="plugin-index" class="table gridview">
                <thead>
                <tr class="table-header">
                    <th>Name</th>
                    <th class="col_description">Description</th>
                    <th>Install Path</th>
                    <th>Uses</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($plugins as $plugin)
                    <tr class="plugin">
                        <td class="data-column"><a href="/plugins/{{ $plugin->id }}">{{ $plugin->title }}</a></td>
                        <td class="data-column col_description">{{ $plugin->description }}</td>
                        <td class="data-column install_path">{{ $plugin->install_path }}</td>
                        <td class="data-column">{{ $plugin->uses_number }}</td>
                        <td><a href="/plugins/edit/{{ $plugin->id }}" class="button is-text btn btn-sm">Edit</a></td>
                        <td>
                            <a
                                href="/plugins/delete/{{ $plugin->id }}"
                                class="button is-text btn btn-sm btn-danger"
                                onclick="return confirm('Really delete plugin \'{{ $plugin->title }}\'?')"
                            >
                                Del
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
                <br>
                <a href="/plugins/create" class="button is-text btn btn-primary mb-3">Add new Plugin</a>
            </div>
        </div>
    </div>
@endsection
