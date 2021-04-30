@extends('layout')

@section('content')
    <h2>Commits @if(isset($plugin)) of Plugin <a href="/plugin/{{ $plugin->id }}">{{ $plugin->title }}</a>@endif</h2>
    @foreach ($commits as $commit)
        <record>
            <div>
                <a href="/commits/{{ $commit->id }}">ID : {{ $commit->id }} - {{ $commit->tag }}</a>
            </div>
        </record>
    @endforeach
@endsection
