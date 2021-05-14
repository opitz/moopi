<head>
    <title>MooSIS - Moodle Submodule Information System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/jquery.tablesorter.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="/list.js"></script>
    <script src="/js/jquery.js"></script>
    <link href="/app.css" rel="stylesheet">
</head>

<div id="wrapper">
        <div id="page" class="container">
            <table class="table">
                <tr class="titlearea">
                    <td class="title">Plugins</td>
                    <td class="title-actions">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="label">No. of Plugins</td>
                    <td id="plugins_number" class="data">{{ count($plugins) }}</td>
                    <td class="data">
                        <input type="text" id="filter" onkeyup="filter_path()" placeholder="Filter install path by...">
                    </td>
                </tr>
            </table>


            <table class="table">
                <div>
                    <tr class="table-header">
                        <th>Name</th>
                        <th>Install Path</th>
                    </tr><tr>
                        <th>Description</th>
                        <th>Developer</th>
                    </tr>
                </div>
                @foreach ($plugins as $plugin)
                    <div>
                        <tr>
                            <td class="title-column">{{ $plugin->title }}</td>
                            <td class="path-column install_path">{{ $plugin->install_path }}</td>
                        </tr><tr>
                            <td class="description-column">{{ $plugin->description }}</td>
                            <td class="developer-column">{{ $plugin->developer }}</td>
                        </tr>
                    </div>
                @endforeach
            </table>
            <div>
                <br>
                <a href="/plugins/create" class="button is-text btn btn-primary mb-3">Add new Plugin</a>
            </div>
        </div>
    </div>

