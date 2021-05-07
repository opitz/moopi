@extends('layout');

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>Edit Plugin</h2>

            <form method="POST" action="/plugins/{{ $plugin->id }}">
                @csrf
                @method('PUT')

                <table>
                    <tr>
                        <td width="10%"><label class="label" for="title">Title</label></td>
                        <td><input class="form-control" type="text" name="title" id="title" value="{{ $plugin->title }}"></td>
                    </tr>
                    <tr>
                        <td><label class="label" for="github_url">GitHub URL</label></td>
                        <td><input class="form-control" type="text" name="github_url" id="github_url" value="{{ $plugin->github_url }}"></td>
                    </tr>
                    <tr>
                        <td><label class="label" for="developer">Developer</label></td>
                        <td><input class="form-control" type="text" name="developer" id="developer" value="{{ $plugin->developer }}"></td>
                    </tr>
                    <tr>
                        <td><label class="label" for="install_path">Install Path</label></td>
                        <td><input class="form-control" type="text" name="install_path" id="install_path" value="{{ $plugin->install_path }}"></td>
                    </tr>
                    <tr>
                        <td><label class="label" for="wiki_url">Wiki URL</label></td>
                        <td><input class="form-control" type="text" name="wiki_url" id="wiki_url" value="{{ $plugin->wiki_url }}"></td>
                    </tr>
                    <tr>
                        <td><label class="label" for="category_id">Category</label></td>
                        <td><input class="form-control" type="text" name="category_id" id="category_id" value="{{ $plugin->category_id }}"></td>
                    </tr>
                    <tr>
                        <td><label class="label" for="description">Description</label></td>
                        <td>
                            <textarea class="form-control" name="description" id="description" value="{{ $plugin->description }}">{{ $plugin->description }}</textarea>
                        </td>
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
