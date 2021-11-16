<head>
    <title>MooSIS - Moodle Submodule Information System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/jquery.tablesorter.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="/js/listtable.js"></script>
    <link href="/listtable.css" rel="stylesheet">
</head>

<div id="wrapper">
    <div id="filter-input">
        <input type="text" id="filter" onkeyup="filter()" placeholder="Filter by...">
    </div>

    <div id="page">
        <div id="fixedheader">
            <table class="header-table">
                <tr>
                    <td class="label">Plugins</td>
                    <td id="plugins_number" class="data">{{ count($plugins) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <th class="table-header">Name</th>
                    <td class="table-header">Install Path</td>
                    <td class="table-header">Developer</td>
                </tr>
            </table>
        </div>

        <div id="plugin-table">
            <table class="table">
                @foreach ($plugins as $plugin)
                    <thead class="plugin">
                        <tr>
                            <td class="title">{{ $plugin->title }}</td>
                            <td class="install_path">{{ $plugin->install_path }}</td>
                            <td class="developer">{{ $plugin->developer }}</td>
                        </tr>
                        <tr>
                            <td class="description" colspan="3">
                                {{ $plugin->description }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info" colspan="3">
                                <mod id="plugin_path">Moodle Plugin Registry: </mod>
                                <a href="{{ $plugin->plugin_url }}" target="_blank">{{ $plugin->plugin_url }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="info" colspan="3">
                                <mod id="more-label">More Information:  </mod>
                                <a href="{{ $plugin->info_url }}" target="_blank">{{ $plugin->info_url }}</a>
                            </td>
                        </tr>
                    </thead>
                @endforeach
            </table>
        </div>

     </div>
</div>

