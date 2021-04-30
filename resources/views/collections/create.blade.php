@extends('layout');

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h2>New Collection</h2>

            <form method="POST" action="/collections">
                @csrf

                <table>
                    <tr>
                        <td width="10%"><label class="name" for="name">Name</label></td>
                        <td><input class="form-control" type="text" name="name" id="name"></td>
                    </tr>
                    <tr>
                        <td width="10%"><label class="moodle_branch" for="moodle_branch">Moodle Branch</label></td>
                        <td><input class="form-control" type="text" name="moodle_branch" id="moodle_branch"></td>
                    </tr>
                </table>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link btn btn-primary mb-3" type="submit">Submit</button>
                        <a href="/collections" class="button is-text btn mb-3">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
