<?php
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

$file = fopen('php://output', 'w');
// export a header
$columns = array('Name', 'Path', 'Repository', 'Developer', 'Version', 'Tag', 'Commit');
fputcsv($file, $columns);
// export a row with information about core Moodle
$moodle_data = array('Moodle', 'core', '', '', $collection->branch->name, $collection->branch->name, '');
fputcsv($file, $moodle_data);

// export all commits and their plugin informations
foreach ($collection->commits as $commit) {
    $row = array(
        $commit->plugin->title,
        $commit->plugin->install_path,
        $commit->plugin->repository_url,
        $commit->plugin->developer,
        $commit->plugin->version,
        $commit->tag,
        $commit->commit_id,
    );
    fputcsv($file, $row);
}
fclose($file);
}
// Redirect to index
return redirect("/collections/$collection->id");
