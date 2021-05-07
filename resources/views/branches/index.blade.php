@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Moodle Branches</h2>

            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Version</th>
                    <th>Repository</th>
                    <th></th>
                </tr>
                @foreach ($branches as $branch)
                    <tr>
                        <td class="data-column"><a href="/branches/{{ $branch->id }}">{{ $branch->name }}</a></td>
                        <td class="data-column">{{ $branch->version }}</td>
                        <td class="data-column">{{ $branch->repository }}</td>
                        <td>
                            <a href="/branches/delete/{{ $branch->id }}" class="button is-text btn btn-danger mb-0">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
@endsection
