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
                        <td class="label" for="branch" width="10%">Moodle Branch</td>
                        <td>
                            <select name="branch_id" id="branch_id">
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Description</td>
                        <td>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </td>
                    </tr>
                </table>
                <div><br></div>
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link btn btn-primary mb-3" type="submit">Submit</button>
                        <a href="/collections" class="butto is-text btn mb-3">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
