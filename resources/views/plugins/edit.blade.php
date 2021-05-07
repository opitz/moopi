@extends('layout');

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <form method="POST" action="/plugins/{{ $plugin->id }}">
                @csrf
                @method('PUT')

                <table class="table">
                    <tr class="titlearea">
                        <td class="title">Edit Plugin</td>
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td class="label">Title</td>
                        <td><input class="form-control" type="text" name="title" id="title" value="{{ $plugin->title }}"></td>
                    </tr>
                    <tr>
                        <td class="label">Description</td>
                        <td>
                            <textarea class="form-control" name="description" id="description" value="{{ $plugin->description }}">{{ $plugin->description }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">GitHub URL</td>
                        <td><input class="form-control" type="text" name="repository_url" id="repository_url" value="{{ $plugin->repository_url }}"></td>
                    </tr>
                    <tr>
                        <td class="label">Developer</td>
                        <td><input class="form-control" type="text" name="developer" id="developer" value="{{ $plugin->developer }}"></td>
                    </tr>
                    <tr>
                        <td class="label">Install Path</td>
                        <td><input class="form-control" type="text" name="install_path" id="install_path" value="{{ $plugin->install_path }}"></td>
                    </tr>
                    <tr>
                        <td class="label">Wiki URL</td>
                        <td><input class="form-control" type="text" name="wiki_url" id="wiki_url" value="{{ $plugin->wiki_url }}"></td>
                    </tr>
                    <tr>
                        <td class="label">Information URL</td>
                        <td><input class="form-control" type="text" name="info_url" id="info_url" value="{{ $plugin->info_url }}"></td>
                    </tr>
                    <tr>
                        <td class="label">Category by</td>
                        <td><input class="form-control" type="text" name="category_id" id="category_id" value="{{ $plugin->category_id }}"></td>
                    </tr>
                    <tr>
                        <td class="label">Requested by</td>
                        <td><input class="form-control" type="text" name="requested_by" id="requested_by" value="{{ $plugin->requested_by }}"></td>
                    </tr>
                    <tr>
                        <td class="label">Requester</td>
                        <td><input class="form-control" type="text" name="requester" id="requester" value="{{ $plugin->requester }}"></td>
                    </tr>
                    <tr>
                        <td class="label">Year Added</td>
                        <td><input class="form-control" type="text" name="year_added" id="year_added" value="{{ $plugin->year_added }}"></td>
                    </tr>
                </table>


                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link btn btn-primary mb-3" type="submit">Submit</button>
                        <a href="/plugins" class="button0 is-text btn mb-3">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
