@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td id="title" class="title">Branches</td>
                    <td class="title-actions">
                    </td>
                </tr>
            </table>

            <table class="table table-striped">
                <tr>
                    <td id="title" style="display: none;">Branches</td>
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
                            <a href="/branches/delete/{{ $branch->id }}" class="button is-text btn btn-sm btn-danger mb-0">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
@endsection
