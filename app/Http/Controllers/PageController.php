<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Session;
use App\Models\Commit;
use App\Models\Plugin;

class PageController extends Controller
{
    public function index() {
        return view('upload.index');
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

                        // Skip first row (Remove below comment if you want to skip the first row)
                        if($i == 0){
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
}
