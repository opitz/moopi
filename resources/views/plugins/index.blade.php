@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Plugins</h2>
            <div>{{ count($plugins) }} found.</div>
            <table>
                @foreach ($plugins as $plugin)
                    <tr>
                        <td class="data-column"><a href="/plugins/{{ $plugin->id }}">{{ $plugin->title }}</a></td>
                        <td class="data-column">{{ $plugin->install_path }}</td>
                        <td class="action-column"><a href="/plugins/edit/{{ $plugin->id }}" class="button is-text btn btn-primary mb-0">Edit</a></td>
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
