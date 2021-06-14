<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Upload;
use Session;
use App\Models\Branch;
use App\Models\Collection;
use App\Models\Commit;
use App\Models\CollectionCommit;
use App\Models\CollectionPlugin;
use App\Models\Plugin;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataController extends Controller
{
    public function upload() {
        return view('data.upload');
    }

    public function uploadFile(Request $request){
        if ($request->input('submit') != null ){

            $file = $request->file('file');

            // File Details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();
            // Valid File Extensions
            $valid_extension = array("csv");

            // 2MB in Bytes
            $maxFileSize = 2097152;

            // Check file extension
            if(in_array(strtolower($extension),$valid_extension)){

                // Check file size
                if($fileSize <= $maxFileSize){

                    // File data location
                    $location = 'uploads';

                    // Upload file
                    $file->move($location,$filename);

                    // Import CSV to Database
                    $filepath = public_path($location."/".$filename);

                    // Reading file
                    $file = fopen($filepath,"r");

                    $importData_arr = array();
                    $i = 0;

                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($filedata );

                        for ($c=0; $c < $num; $c++) {
                            $importData_arr[$i][] = $filedata [$c];
                        }
                        $i++;
                    }
                    fclose($file);

                    // Insert to MySQL database
                    $collection = $this->insertdata($filename,$importData_arr);

                    Session::flash('message','Import Successful.');
                }else{
                    Session::flash('message','File too large. File must be less than 2MB.');
                }

            }else{
                Session::flash('message','Invalid File Extension.');
            }

        }

        // Redirect to index
        return redirect("/collections/$collection->id");
    }

    protected function insertdata($filename,$importData_arr) {
        $i = 0;
        $moodle_branch = $importData_arr[1][5]; // The Moodle branch is in the 6th field of the 2nd row
        $moodle_repository = $importData_arr[1][2]; // The Moodle repository is in the 3rd field of the 2nd row
        $moodle_version = $importData_arr[1][4]; // The Moodle repository is in the 5th field of the 2nd row
        // Create a new collection
        $collection = $this->create_collection($filename, $moodle_branch, $moodle_repository, $moodle_version);

        // Now import the data row by row
        foreach($importData_arr as $importData){
            if ($i < 2) { // skip header row and the 2nd row with Moodle data
                $i++;
                continue;
            }

            // Check if the Plugin record already exists and create one if not
            $repository_url = $importData[2];
            $plugins = Plugin::where('repository_url', $repository_url)->get();
            if ($plugins->count() == 0) {
                $plugin = Plugin::create([
                    'title' => $importData[0],
                    'install_path' => $importData[1],
                    'repository_url' => $importData[2],
                    'github_url' => $importData[3],
                    'developer' => $importData[4],
                ]);
            } else {
                $plugin = $plugins->first(); // else the plugin is the 1st (and only) member of the returned collection
            }
            $cp = CollectionPlugin::create([
                'collection_id' => $collection->id,
                'plugin_id' => $plugin->id
            ]);

            // Check if the Commit record already exists and create one if not
            $commit_id = $importData[6];
            $commits = Commit::where('commit_id', $commit_id)->get();
            if ($commits->count() == 0) {
                $commit = Commit::create([
                    'plugin_id' => $plugin->id,
                    'commit_id' => $importData[7],
                    'tag' => $importData[6],
                    'version' => $importData[5]
                ]);
            } else {
                $commit = $commits->first();
            }
            $cc = CollectionCommit::create([
                'collection_id' => $collection->id,
                'commit_id' => $commit->id
            ]);

        }
        return $collection;
    }

    protected function create_collection($filename, $moodle_branch, $moodle_repository, $moodle_version) {
        // Check if the branch exists and add it otherwise
        $branch = Branch::where('name',$moodle_branch);
        if ($branch->count() == 0) {
            $branch = Branch::create([
                'name' => $moodle_branch,
                'repository' => $moodle_repository,
                'version' => $moodle_version
            ]);
        } else {
            $branch = ($branch->first());
        }

        // Now create a Collection with that branch
        $name = $filename;
        $name = pathinfo($filename)['filename'];

        // Check if no file exists with the $name otherwise add a number to it until you find an unused name
        $i = 0;
        $collection = Collection::where('name',$name)->get();
        while ($collection->count() != 0) {
            $collection = Collection::where('name',$name.'_'.++$i)->get();
        }

        $collection = Collection::create([
            'name' => $name.(!$i ? '' : '_'.$i), // only amend the number to the name if it is > 0
            'branch_id' => $branch->id
        ]);

        return $collection;
    }

    public function export0($id) {
        $collection = Collection::find($id);
        if ($collection->count() > 0) {
            // Open the file for writing
//            $filename = '/Users/opitz/workbench/moopie/exporttest.csv';
//            $file = fopen($filename, 'w+');
            $filename = pathinfo($collection->name);
            $filename = $filename['filename'] . '.csv';
//            ddd($filename);
            // send data headers so browsers will download not display
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$filename");
            $file = fopen("php://output",'w');

            // export a header
            $columns = array('Name', 'Path', 'Repository', 'Developer', 'Version', 'Tag', 'Commit');
            fputcsv($file, $columns);
            // export a row with information about core Moodle
            $moodle_data = array('Moodle', 'core', $collection->branch->repository, '', $collection->branch->version, $collection->branch->name, '');
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
//                fputcsv($file, $row);
            }
            // export all plugins and their commits informations
            foreach ($collection->plugins as $plugin) {
                $commit_version = '';
                $commit_tag = '';
                $commit_commit_id = '';
                foreach ($plugin->commits as $pcommit) {
                    if($collection->hasCommit($pcommit->id)) {
                        $commit_version = $pcommit->version;
                        $commit_commit_id = $pcommit->commit_id;
                        $commit_tag = $pcommit->tag;
                        break;
                    }
                }
                $row = array(
                    $plugin->title,
                    $plugin->install_path,
                    $plugin->repository_url,
                    $plugin->developer,
                    $commit_version,
                    $commit_tag,
                    $commit_commit_id,
                );
                fputcsv($file, $row);
            }
            fclose($file);
        }
        // Redirect to index
        return redirect("/collections/$collection->id");
    }
    public function exportCollection($id) {
        $collection = Collection::find($id);
        if ($collection->count() > 0) {
            // Open the file for writing
            $filename = pathinfo($collection->name);
            $filename = $filename['filename'] . '.csv';

            // send data headers so browsers will download not display
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$filename");
            $file = fopen("php://output",'w');

            // export a header
            $columns = array(
                'Name',
                'Path',
                'Repository',
                'GitHub',
                'Developer',
                'Version',
                'Tag',
                'Commit',
                'PluginURL',
                'WikiURL',
                'InfoURL',
                'Requester',
                'Year added',
                'Public',
                'Description'
            );
            fputcsv($file, $columns);

            // export a row with information about core Moodle
            $moodle_data = array('Moodle', 'core', $collection->branch->repository, '', $collection->branch->version, $collection->branch->name, '');
            fputcsv($file, $moodle_data);

            // export all plugins and their commits informations
            foreach ($collection->plugins as $plugin) {
                $commit_version = '';
                $commit_tag = '';
                $commit_commit_id = '';
                foreach ($plugin->commits as $pcommit) {
                    if($collection->hasCommit($pcommit->id)) {
                        $commit_version = $pcommit->version;
                        $commit_commit_id = $pcommit->commit_id;
                        $commit_tag = $pcommit->tag;
                        break;
                    }
                }
                $row = array(
                    $plugin->title,
                    $plugin->install_path,
                    $plugin->repository_url,
                    $plugin->github_url,
                    $plugin->developer,
                    $commit_version,
                    $commit_tag,
                    $commit_commit_id,
                    $plugin->plugin_url,
                    $plugin->wiki_url,
                    $plugin->info_url,
                    $plugin->requester,
                    $plugin->year_added,
                    $plugin->public,
                    $plugin->description,
                );
                fputcsv($file, $row);
            }
            fclose($file);
        }
        // Redirect to index
        return redirect("/collections/$collection->id");
    }

    public function exportPlugins() {
        $plugins = Plugin::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headerfields = ['Title',
            'Install Path',
            'Repository',
            'Description',
            'GitHub',
            'Developer',
            'Plugin URL',
            'Wiki URL',
            'Info URL',
            'Requester',
            'Year added'
            ,'Public'];

        $sheet->fromArray(
                $headerfields,   // The data to set
                NULL,        // Array values with this value will not be set
                'A1'         // Top left coordinate of the worksheet range where
            //    we want to set these values (default is A1)
            );
        if ($plugins) foreach ($plugins as $key => $plugin) {
            $row = array();
            $row['title'] = $plugin->title;
            $row['install_path'] = $plugin->install_path;
            $row['repository_url'] = $plugin->repository_url;
            $row['description'] = $plugin->description;
            $row['github_url'] = $plugin->github_url;
            $row['developer'] = $plugin->developer;
            $row['plugin_url'] = $plugin->plugin_url;
            $row['wiki_url'] = $plugin->wiki_url;
            $row['info_url'] = $plugin->info_url;
            $row['requester'] = $plugin->requester;
            $row['yead_added'] = $plugin->year_added;
            $row['public'] = $plugin->public;

            $sheet->fromArray(
                $row,   // The data to set
                NULL,        // Array values with this value will not be set
                'A'.((int)$key+2)         // Top left coordinate of the worksheet range where
            );
        }
//        $sheet->setCellValue('A1', 'Hello World !');

        // send data headers so browsers will download not display
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename='ExcelExportTest.xlsx'");

        $writer = new Xlsx($spreadsheet);
        $writer->save('ExcelExportTest.xlsx');

        return redirect("/plugins");
    }
}
