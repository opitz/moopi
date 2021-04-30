@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Collections</h2>
            @foreach ($collections as $collection)
                <record>
                    <div>
                        <a href="/collections/{{ $collection->id }}">{{ $collection->name }}</a>
                    </div>
                </record>
            @endforeach
            <div>
                <br>
                <a href="/collections/create" class="button is-text btn btn-primary mb-3">Add new Collection</a>
            </div>
        </div>
    </div>
@endsection
