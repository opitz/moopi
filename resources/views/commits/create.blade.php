@extends('layout');

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>New Commit</h2>

            <form method="POST" action="/commits">
                @csrf

                <table>
                    <tr>
                        <td id="title" style="display: none;">Plugin</td>
                        <td width="10%"><label class="label" for="plugin_id">Plugin</label></td>
                        <td>
                            <input class="form-control" type="hidden" name="plugin_id" id="{{ $plugin->id }}" value="{{ $plugin->id }}">
                            {{ $plugin->title }}
                        </td>
                    </tr>
                    <tr>
                        <td><label class="label" for="commit_id">Commit ID</label></td>
                        <td><input class="form-control" type="text" name="commit_id" id="commit_id"></td>
                    </tr>
                    <tr>
                        <td><label class="label" for="tag">Tag</label></td>
                        <td><input class="form-control" type="text" name="tag" id="tag"></td>
                    </tr>
                    <tr>
                        <td><label class="label" for="version">Version</label></td>
                        <td><input class="form-control" type="text" name="version" id="version"></td>
                    </tr>
                </table>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link btn btn-primary mb-3" type="submit">Submit</button>
                        <a href="/plugins/{{ $plugin->id }}" class="button0 is-text btn mb-3">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
