@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td class="title">Collections</td>
                    <td class="title-actions">
                        <a href="/upload" id="upload_collection" class="button is-text btn btn-primary mb-3">Upload Collection</a>
                        <a href="/collections/create" class="button is-text btn btn-primary mb-3">Add new Collection</a>
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
                        <td class="data-column">{{ $collection->commits->count() }}</td>
                        <td>
                            <a href="/collections/duplicate/{{ $collection->id }}" class="button is-text btn btn-primary mb-0">Duplicate</a>
                            <a href="/collections/add/{{ $collection->id }}" class="button is-text btn btn-primary mb-0">Add</a>
                            <a href="/collections/edit/{{ $collection->id }}" class="button is-text btn btn-primary mb-0">Edit</a>
                            <a href="/collections/export/{{ $collection->id }}" class="button is-text btn btn-primary mb-0">Export</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
