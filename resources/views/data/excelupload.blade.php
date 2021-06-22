@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td id="title" class="title">Load Plugin Information</td>
                    <td class="title-actions">
                    </td>
                </tr>
            </table>

            <p></p>
            <!-- Message -->
            @if(Session::has('message'))
                <p >{{ Session::get('message') }}</p>
            @endif



            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Upload Excel File</h3>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            <form role="form" method="post" action='/plugins/importFile' enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Document (.xlsx) <small style="color: red">*</small></label>
                                    <input type="file" name="file1" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

@endsection
