@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Collections</h2>

            <table>
                <tr>
                    <th class="w150">Collection</th>
                    <th class="w250">Updated at</th>
                    <th class="w250">Moodle Branch</th>
                    <th class="w150 center">No. of Plugins</th>
                    <th></th>
                </tr>
                @foreach ($collections as $collection)
                    <tr>
                        <td class="data-column"><a href="/collections/{{ $collection->id }}">{{ $collection->name }}</a></td>
                        <td class="data-column">{{ $collection->updated_at }}</td>
                        <td class="data-column">{{ $collection->branch->name }}</td>
                        <td class="data-column">{{ $collection->commits->count() }}</td>
                        <td>
                            <a href="/collections/export/{{ $collection->id }}" class="button is-text btn btn-primary mb-0">Export</a>
                            <a href="/collections/delete/{{ $collection->id }}" class="button is-text btn btn-primary mb-0">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>

            <div>
                <br>
                <a href="/upload" class="button is-text btn btn-primary mb-3">Upload Collection</a>
                <a href="/collections/create" class="button is-text btn btn-primary mb-3">Add new Collection</a>
            </div>
        </div>
    </div>
@endsection
