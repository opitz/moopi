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
    // Plugins
    public function pluginTemplate() {
        return [
            "repository_url" => "Repository URL",
            "title" => "Title",
            "github_url" => "GitHub URL",
            "install_path" => "Install Path",
            "developer" => "Developer",
            "description" => "Description",
            "plugin_url" => "Plugin URL",
            "wiki_url" => "Wiki URL",
            "info_url" => "Info URL",
            "requester" => "Requester",
            "year_added" => "Year added",
            "uses_number" => "Nr of Uses",
            "public" => "Public",
        ];
    }

    public function pluginUpload() {
        return view('data.excelupload');
    }

    public function pluginUploadFile(Request $request) {
        $request->validate([
            'file1' => 'required|mimes:xlsx|max:10000'
        ]);
        $file = $request->file('file1');
        $name = time().'.xlsx';
        $path = public_path('documents'.DIRECTORY_SEPARATOR);

        if ( $file->move($path, $name) ){
            $inputFileName = $path.$name;
            $spreadSheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

            $sheet = $spreadSheet->getSheet(0)->toArray();
            $plugins = [];
            foreach ($sheet as $key => $row) {
                if ($key < 1) {
                    continue; // Do not process the header row.
                }
                $this->importPluginData($row);
            }
            return redirect("/plugins");
        }
    }

    protected function importPluginData($row) {
        $template = $this->pluginTemplate();
        $pluginKeys = array_keys($template);

        // Using the repository URL as unique identifyer for a plugin.
        $uid = 'repository_url';
        $repository_url = $row[array_search($uid, $pluginKeys)];
        $plugin = Plugin::where('repository_url',$repository_url)->first();
        if ($plugin && $repository_url) {
            foreach ($pluginKeys as $index => $key) {
                $plugin->$key = $row[$index];
            }
            if ($plugin->title === NULL) {
                $plugin->title = 'n.a.';
            }
            if ($plugin->public != NULL) {
//                ddd($plugin->public);
                $plugin->public = '1';
            }
            return $plugin->save();
        }
        return false;
    }

    public function exportPlugins() {
        $plugins = Plugin::orderBy('title')->get();

        $datestring = date("ymd");
        $fileName = "MooSIS-PluginList_$datestring.xlsx";

        $this->export2excel($plugins, $fileName);
    }

    public function exportCollectionPlugins($collection_id) {
        $collection = Collection::where('id',$collection_id)->first();
        $plugins = Plugin::whereHas(
            'collections', function($q) use ($collection_id) {
            $q->where('collection_id', $collection_id);
        }
        )->orderBy('title')->get();

        // Set the file name
        $fileName = "MooSIS-".$collection->name.".xlsx";

        $this->export2excel($plugins, $fileName);
    }

    protected function export2excel($plugins, $fileName) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $template = $this->pluginTemplate();
        $pluginKeys = array_keys($template);

        $sheet->fromArray(
            $template,       // The data to set
            NULL,       // Array values with this value will not be set
            'A1'         // Top left coordinate of the worksheet range where
                                  //    we want to set these values (default is A1)
        );
        if ($plugins) foreach ($plugins as $key => $plugin) {
            $row = array();
            foreach ($pluginKeys as $pluginKey) {
                $row[$pluginKey] = $plugin->$pluginKey;
            }
            // Add the row to the sheet starting with row 2
            $sheet->fromArray($row,NULL, 'A'.((int)$key+2));
        }

        // Formatting
        $sheet->getColumnDimension('A')->setVisible(false); // hide the repository_url
        $sheet->getColumnDimension('C')->setVisible(false); // hide the github_url
        $sheet->getColumnDimension('D')->setVisible(false); // hide the install_path

        $sheet->getColumnDimension('B')->setWidth(40); // set width of title column
        $sheet->getColumnDimension('E')->setWidth(40); // set width of developer column
        $sheet->getColumnDimension('F')->setWidth(80); // set width of description column
        $sheet->getColumnDimension('G')->setWidth(40); // set width of plugin_url column
        $sheet->getColumnDimension('H')->setWidth(40); // set width of wiki_url column
        $sheet->getColumnDimension('I')->setWidth(40); // set width of info_url column
        $sheet->getColumnDimension('J')->setWidth(40); // set width of requester column

        // Formatting the header
        $header = $sheet->getStyle('A1:L1');
        $header->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKBLUE);
        $header->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $header->getFill()->getStartColor()->setARGB('FFCCCCCC');
        $header->getFont()->setBold(true);

        // Set cells to wrap text
        $sheet->getStyle('E1:F999')->getAlignment()->setWrapText(true);
        // Set cells to vertical align at the top
        $sheet->getStyle('A:L')->getAlignment()->setVertical('top');

        // Finally write the file
        $writer = new Xlsx($spreadsheet);

        // Send data headers so browsers will download not display
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }


    // Collections
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
                    $collection = $this->insertCollectionData($filename,$importData_arr);

                    Session::flash('message','Import Successful.');
                }else{
                    Session::flash('message','File too large. File must be less than 2MB.');
                }

            }else{
                Session::flash('message','Invalid File Extension.');
            }

        }

        // Redirect to the collection page
        return redirect("/collections/$collection->id");
    }

    protected function insertCollectionData($filename,$importData_arr) {
        $i = 0;
        $moodle_tag = $importData_arr[1][6]; // The Moodle branch is in the 7th field of the 2nd row
        $moodle_repository = $importData_arr[1][2]; // The Moodle repository is in the 3rd field of the 2nd row
        $moodle_version = $importData_arr[1][5]; // The Moodle repository is in the 6th field of the 2nd row
        // Create a new collection
        $collection = $this->create_collection($filename, $moodle_tag, $moodle_repository, $moodle_version);

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

    protected function create_collection($filename, $moodle_tag, $moodle_repository, $moodle_version) {
        // Check if the branch exists and add it otherwise
        $branch = Branch::where('name',$moodle_tag);
        if ($branch->count() == 0) {
            $branch = Branch::create([
                'name' => $moodle_tag,
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

}
