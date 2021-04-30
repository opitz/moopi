@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Collection</h2>

            <table class="table">
                <tr>
                    <td class="label" width="10%">Name</td>
                    <td class="data">{{ $collection->name }}</td>
                </tr>
                <tr>
                    <td class="label" width="10%">Moodle Branch</td>
                    <td class="data">{{ $collection->moodle_branch }}</td>
                </tr>
                <tr>
                    <td class="label" width="10%">Plugins</td>
                    <td class="data">
                        <ul>
                            @foreach($collection->commits as $commit)
                                <li><a href="/commits/{{ $commit->id }}">{{ $commit->plugin->title }} / {{ $commit->tag }}</a></li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>
            <div>
                <br>
                <a href="/collections/delete/{id}" class="button is-text btn btn-primary mb-3">Delete Collection</a>
            </div>
        </div>
    </div>
@endsection
