<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommitController;
use App\Http\Controllers\PluginController;
use App\Http\Controllers\DataController;
use App\Models\Commit;
use App\Models\Collection;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/list',[PluginController::class,'list']);

Route::get('/test', function () {
    return view('collections.test');
});

Route::get('/laravel', function () {
    return view('welcome');
});
// Sequence is important here as it will parse top to bottom
// and when an URL matches the route takes place leaving those behind that are

Route::get('/',[CollectionController::class,'index']);

Route::get('/home0',[HomeController::class,'index'])->name('home.index');
Route::get('/home',[HomeController::class,'index']);

// Plugins
// Put the changes into the database
Route::put('plugins/{plugin}', [PluginController::class, 'update']);

// Get a list of all plugins
Route::get('/plugins',[PluginController::class,'index']);
// Add a new Plugin resource
Route::get('/plugins/create',[PluginController::class,'create']);
// Store the Plugin resource
Route::post('/plugins',[PluginController::class,'store']);
Route::get('/plugins/edit/{plugin}',[PluginController::class,'edit']);

// Show a single resource
Route::get('/plugins/{plugin}',[PluginController::class,'show']);

// Delete Plugin resource
Route::get("plugins/delete/{plugin}",[PluginController::class,'destroy']);

// Commits
// Add a new Commit resource
Route::get("/commits/create/{plugin_id}",[CommitController::class,'create']);
// Store the Commit resource
Route::post("/commits",[CommitController::class,'store']);
Route::get('/commits',[CommitController::class,'index']);
// Delete Commit resource
Route::get("commits/delete/{commit}",[CommitController::class,'destroy']);
Route::get("commits/delete_selected",[CommitController::class,'destroy_selected']);
Route::get('/commits/{commit}',[CommitController::class,'show']);

// Collections
// Put the changes into the database
Route::put('collections/{collection}', [CollectionController::class, 'update']);
Route::put('collections/add_plugins/{collection}', [CollectionController::class, 'add_plugins']);
// Add a new Collection resource
Route::get("collections/create/",[CollectionController::class,'create']);
// Store the Collection resource
Route::post("collections",[CollectionController::class,'store']);
// Delete the Collection resource
Route::get("collections/delete/{collection}",[CollectionController::class,'destroy']);
Route::get('collections',[CollectionController::class,'index']);
Route::get('collections/{collection}',[CollectionController::class,'show']);
Route::get('collections/duplicate/{collection}',[CollectionController::class,'replicate']);
Route::get('collections/edit/{collection}',[CollectionController::class,'edit']);
Route::get('collections/detach_commits/{collection}',[CollectionController::class,'detach']);
Route::get('collections/add/{collection}',[CollectionController::class,'add']);

Route::get('collections/add0/{collection}', function (Collection $collection) {
    $non_commits = array();
    $commits = Commit::all();
    foreach ($commits as $commit) {
        if (!$commit->hasCollection($collection->id)) {
            $non_commits[] = $commit;
        }
    }
//    ddd($non_commits);
    return view('collections.add', ['collection' => $collection,'commits' => $non_commits]);
});

// Branches
Route::get('/branches', [BranchController::class,'index']);





// GET = read, POST = create, PUT = update, DELETE = delete

// GET /plugins
// GET /plugins/:id
// POST /plugins
// PUT /plugins/:id
// DELETE /plugins/:id

Route::get('/upload', [DataController::class, 'upload']);
Route::post('/uploadFile', [DataController::class, 'uploadFile']);
Route::get('/collections/export/{collection}', [DataController::class, 'export']);
