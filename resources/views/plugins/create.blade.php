@extends('layout');

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>New Plugin</h2>

            <form method="POST" action="/plugins">
                @csrf

                <table>
                    <tr>
                        <td width="10%"><label class="label" for="title">Title</label></td>
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
                        <td><label class="label" for="github_url">GitHub URL</label></td>
                        <td><input class="form-control @error('github_url') is-invalid @enderror" type="text" name="github_url" id="github_url"></td>
                        @if ($errors->has('github_url'))
                            <td class="feedback">{{ $errors->first('github_url') }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td><label class="label" for="developer">Developer</label></td>
                        <td><input class="form-control" type="text" name="developer" id="developer"></td>
                    </tr>
                    <tr>
                        <td><label class="label" for="install_path">Install Path</label></td>
                        <td><input class="form-control @error('install_path') is-invalid @enderror" type="text" name="install_path" id="install_path"></td>
                        @if ($errors->has('install_path'))
                            <td class="feedback">{{ $errors->first('install_path') }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td><label class="label" for="wiki_url">Wiki URL</label></td>
                        <td><input class="form-control" type="text" name="wiki_url" id="wiki_url"></td>
                    </tr>
                    <tr>
                        <td><label class="label" for="category_id">Category</label></td>
                        <td><input class="form-control" type="text" name="category_id" id="category_id"></td>
                    </tr>
                    <tr>
                        <td><label class="label" for="description">Description</label></td>
                        <td>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </td>
                    </tr>
                </table>

                <br>
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link btn btn-primary mb-3" type="submit">Submit</button>
                        <a href="/plugins" class="button is-text btn mb-3">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
