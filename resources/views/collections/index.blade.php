@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td id="title" class="title">Collections</td>
                    <td class="title-actions">
                        <a href="/upload" id="upload_collection" class="button is-text btn btn-sm">Upload Collection</a>
                        <a href="/collections/create" class="button is-text btn btn-sm">Add new Collection</a>
                    </td>
                </tr>
            </table>

            <table class="table">
                <thead>
                <tr>
                    <th class="w150">Collection</th>
                    <th class="w250">Updated at</th>
                    <th class="w250">Moodle Branch</th>
                    <th class="w150 center">No. of Plugins</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($collections as $collection)
                    <tr>
                        <td class="data-column"><a href="/collections/{{ $collection->id }}">{{ $collection->name }}</a></td>
                        <td class="data-column">{{ $collection->updated_at }}</td>
                        <td class="data-column">{{ $collection->branch->name }}</td>
                        <td class="data-column">{{ $collection->plugins->count() }}</td>
                        <td class="collection-buttons">
                            <a href="/collections/duplicate/{{ $collection->id }}" class="button is-text btn btn-sm">Duplicate</a>
                            <a href="/collections/add/{{ $collection->id }}" class="button is-text btn btn-sm">Add</a>
                            <a href="/collections/edit/{{ $collection->id }}" class="button is-text btn btn-sm">Edit</a>
                            <a href="/collections/export/{{ $collection->id }}" class="button is-text btn btn-sm btn-success">Export</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
