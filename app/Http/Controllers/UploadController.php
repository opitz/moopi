<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Upload;
use Session;
use App\Models\Branch;
use App\Models\Collection;
use App\Models\Commit;
use App\Models\CollectionCommit;
use App\Models\Plugin;

class UploadController extends Controller
{
    public function index() {
        return view('upload.index');
    }

    public function uploadFile0(Request $request){
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

                    // File upload location
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

                        // Skip first row (Remove below comment if you want to skip the first row)
                        if ($i < 2) {
                            $i++;
                            continue;
                        }

                        for ($c=0; $c < $num; $c++) {
                            $importData_arr[$i][] = $filedata [$c];
                        }
                        $i++;
                    }
                    fclose($file);

                    // Insert to MySQL database
                    foreach($importData_arr as $importData){
                        $github_url = $importData[2];
                        $plugins = Plugin::where('github_url', $github_url)->get();
                        if ($plugins->count() == 0) {
                            $plugin = Plugin::create([
                                'title' => $importData[0],
                                'install_path' => $importData[1],
                                'github_url' => $importData[2],
                                'developer' => $importData[3],
                            ]);
                        } else {
                            $plugin = $plugins[0];
                        }

                        $commit_id = $importData[6];
                        $commit = Commit::where('commit_id',$commit_id)->get();
                        if ($commit->count() == 0) {
//                            ddd($plugin);
                            $commit = Commit::create([
                                'plugin_id' => $plugin->id,
                                'commit_id' => $importData[6],
                                'tag' => $importData[5],
                                'version' => $importData[4]
                            ]);
                        }

//                        ddd($plugin);
                        /*
                                                $pluginData = array(
                                                    "username"=>$importData[1],
                                                    "name"=>$importData[2],
                                                    "gender"=>$importData[3],
                                                    "email"=>$importData[4]);
                                                Plugin::insertData($insertData);
                        */
                    }

                    Session::flash('message','Import Successful.');
                }else{
                    Session::flash('message','File too large. File must be less than 2MB.');
                }

            }else{
                Session::flash('message','Invalid File Extension.');
            }

        }

        // Redirect to index
        return redirect('/plugins');
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

                    // File upload location
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
                    $this->insertdata($filename,$importData_arr);

                    Session::flash('message','Import Successful.');
                }else{
                    Session::flash('message','File too large. File must be less than 2MB.');
                }

            }else{
                Session::flash('message','Invalid File Extension.');
            }

        }

        // Redirect to index
        return redirect('/plugins');
    }

    protected function insertdata($filename,$importData_arr) {
        $is_collection = false;
        $i = 0;
        foreach($importData_arr as $importData){
            if ($i == 0) { // skip header row
                $i++;
                continue;
            }
            // Get Moodle data
            if ($i == 1) {
                $moodle_branch = $importData[5];
                $i++;
                continue;
            }
            $github_url = $importData[2];
            $plugins = Plugin::where('github_url', $github_url)->get(); // Check if the plugin exists.
            if ($plugins->count() == 0) {
                $plugin = Plugin::create([
                    'title' => $importData[0],
                    'install_path' => $importData[1],
                    'github_url' => $importData[2],
                    'developer' => $importData[3],
                ]);
            } else {
                $plugin = $plugins[0];
            }

            $commit_id = $importData[6];
            $commit = Commit::where('commit_id',$commit_id)->get();
            if ($commit->count() == 0) {
                if (!$is_collection) { # if the collection flag is not set create a new collection
                    $collection = $this->create_collection($filename, $moodle_branch);
                    if ($collection->count() > 0) {
                        $is_collection = true;
                    }
                }
                $commit = Commit::create([
                    'plugin_id' => $plugin->id,
                    'commit_id' => $importData[6],
                    'tag' => $importData[5],
                    'version' => $importData[4]
                ]);
                if ($is_collection) {
                    $cc = CollectionCommit::create([
                        'collection_id' => $collection->id,
                        'commit_id' => $commit->id
                    ]);
                }
            }
        }
    }

    protected function create_collection($filename, $moodle_branch) {
        // Check if the branch exists and add it otherwise
        $branch = Branch::where('name','$moodle_branch');
        if ($branch->count() == 0) {
            $branch = Branch::create([
                'name' => $moodle_branch
            ]);
        }

        // Now create a Collection with that branch
        $i = 0;
        $name = $filename;
        $collection = Collection::where('name',$name)->get();
        while ($collection->count() != 0) {
            $collection = Collection::where('name',$name.'_'.++$i)->get();
        }
        $collection = Collection::create([
            'name' => $name.(!$i ? '' : '_'.$i),
            'branch_id' => $branch->id
        ]);

        return $collection;
    }
}
