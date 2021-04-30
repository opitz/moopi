<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommitController;
use App\Http\Controllers\PluginController;
use App\Http\Controllers\UploadController;
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

Route::get('/laravel', function () {
    return view('welcome');
});
// Sequence is important here as it will parse top to bottom
// and when an URL matches the route takes place leaving those behind that are

Route::get('/',HomeController::class);

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


// Commits
// Add a new Commit resource
Route::get("/commits/create/{plugin_id}",[CommitController::class,'create']);
// Store the Commit resource
Route::post("/commits",[CommitController::class,'store']);
Route::get('/commits',[CommitController::class,'index']);
Route::get('/commits/{commit}',[CommitController::class,'show']);

// Collections
// Add a new Collection resource
Route::get("/collections/create/",[CollectionController::class,'create']);
// Store the Collection resource
Route::post("/collections",[CollectionController::class,'store']);
// Delete the Collection resource
Route::post("/collections/delete/{collection}",[CollectionController::class,'destroy']);
Route::get('/collections',[CollectionController::class,'index']);
Route::get('/collections/{collection}',[CollectionController::class,'show']);

// GET = read, POST = create, PUT = update, DELETE = delete

// GET /plugins
// GET /plugins/:id
// POST /plugins
// PUT /plugins/:id
// DELETE /plugins/:id

Route::get('/upload', [UploadController::class, 'index']);
Route::post('/uploadFile', [UploadController::class, 'uploadFile']);
