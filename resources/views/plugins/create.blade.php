@extends('layout');

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <form method="POST" action="/plugins">
                @csrf
                <table class="table">
                    <tr class="titlearea">
                        <td id="title" style="display: none;">Plugin</td>
                        <td class="title" colspan="2">New Plugin</td>
                        <td>Public <input type="checkbox" name="public" id="public" value="1"></td>
                    </tr>

                    <tr>
                        <td class="label">Title</td>
                        <td><input
                                class="form-control @error('title') is-invalid @enderror"
                                type="text" name="title"
                                id="title"
                                value="{{ old('title') }}">
                        </td>
                        @if ($errors->has('title'))
                            <td class="feedback">{{ $errors->first('title') }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="label">Description</td>
                        <td>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Repository URL</td>
                        <td><input class="form-control @error('repository_url') is-invalid @enderror" type="text" name="repository_url" id="repository_url"></td>
                        @if ($errors->has('repository_url'))
                            <td class="feedback">{{ $errors->first('repository_url') }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="label">GitHub URL</td>
                        <td><input class="form-control @error('github_url') is-invalid @enderror" type="text" name="github_url" id="github_url"></td>
                        @if ($errors->has('github_url'))
                            <td class="feedback">{{ $errors->first('github_url') }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="label">Developer</td>
                        <td><input class="form-control" type="text" name="developer" id="developer"></td>
                    </tr>
                    <tr>
                        <td class="label">Install Path</td>
                        <td><input class="form-control @error('install_path') is-invalid @enderror" type="text" name="install_path" id="install_path"></td>
                        @if ($errors->has('install_path'))
                            <td class="feedback">{{ $errors->first('install_path') }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="label">Wiki URL</td>
                        <td><input class="form-control" type="text" name="wiki_url" id="wiki_url"></td>
                    </tr>
                    <tr>
                        <td class="label">Information URL</td>
                        <td><input class="form-control" type="text" name="info_url" id="info_url"></td>
                    </tr>
                    <tr>
                        <td class="label">Plugin URL</td>
                        <td><input class="form-control" type="text" name="plugin_url" id="plugin_url"></td>
                    </tr>
                    <tr>
                        <td class="label">Category</td>
                        <td><input class="form-control" type="text" name="category_id" id="category_id"></td>
                    </tr>
                    <tr>
                        <td class="label">Requested by</td>
                        <td><input class="form-control" type="text" name="requested_by" id="requested_by"></td>
                    </tr>
                    <tr>
                        <td class="label">Requester</td>
                        <td><input class="form-control" type="text" name="requester" id="requester"></td>
                    </tr>
                    <tr>
                        <td class="label">Year Added</td>
                        <td><input class="form-control" type="text" name="year_added" id="year_added"></td>
                    </tr>
                    <tr>
                        <td class="label">Number of Uses</td>
                        <td><input class="form-control" type="text" name="uses_number" id="uses_number"></td>
                    </tr>
                </table>

                <br>
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
