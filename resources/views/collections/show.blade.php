@extends('layout')

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td class="title">Collection</td>
                    <td class="title-actions">
                        <a href="/collections/duplicate/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Duplicate</a>
                        <a href="/collections/add/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Add</a>
                        <a href="/collections/edit/{{ $collection->id }}" class="button is-text btn btn-primary mb-3">Edit</a>
                        <a href="/collections/export/{{ $collection->id }}" class="button is-text btn btn-success mb-3">Export</a>
                    </td>
                </tr>

                <tr>
                    <td class="label" width="10%">Name</td>
                    <td class="data">{{ $collection->name }}</td>
                </tr>
                <tr>
                    <td class="label" width="10%">Moodle Branch</td>
                    <td class="data">{{ $collection->branch->name }}</td>
                </tr>
                <tr>
                    <td class="label" width="10%">No. of Plugins</td>
                    <td id="plugins_number" class="data">{{ $collection->commits()->count() }}</td>
                </tr>
                <tr>
                    <td class="label" width="10%">Filter Path</td>
                    <td class="data">
                        <input type="text" id="filter" onkeyup="filter()" placeholder="Filter install path by...">
                    </td>
                </tr>

            </table>

            <table class="table">
                <tr>
                    <th>Plugin</th>
                    <th>Path</th>
                    <th>Commit ID</th>
                    <th>Tag</th>
                </tr>
                @foreach($collection->commits as $commit)
                    <tr class="commit-row">
                        <td class="data-column"><a href="/plugins/{{ $commit->plugin->id }}">{{ $commit->plugin->title }}</a></td>
                        <td class="data-column install_path"><a href="/plugins/{{ $commit->plugin->id }}">{{ $commit->plugin->install_path }}</a></td>
                        <td class="data-column"><a href="/commits/{{ $commit->id }}">{{ substr($commit->commit_id,0,10).'...' }}</a></td>
                        <td class="data-column">{{ $commit->tag }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <script>
        function filter() {
            // Declare variables
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('filter');
            filter = input.value;

            var counter = document.getElementsByClassName("install_path").length;

            // Loop through all commits
            // hide those where the plugin install path do not match the filter query
            // and show those where the filter query matches
            var showing = 0;
            for (i = 0; i < counter; i++) {
                var pathelement = document.getElementsByClassName("install_path")[i];
                var path = pathelement.getElementsByTagName("a")[0].innerHTML;
                if (path.indexOf(filter) == -1) {
                    pathelement.parentNode.style.display = "none";
                } else {
                    pathelement.parentNode.style.display = "table-row";
                    showing++;
                }
            }
            // Display the number of shown plugins
            var text2display = "Showing " + showing + " of {{ $collection->commits()->count() }}"
            document.getElementById('plugins_number').innerHTML = text2display;
        }
        function test() {
//            var counter = document.getElementsByTagName("td.install_path").length;
            var counter = document.getElementsByClassName("install_path").length;
            alert(counter);
        }
    </script>
@endsection
