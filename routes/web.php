<?php

use App\Http\Controllers\GenerarCalculosExcel;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [GenerarCalculosExcel::class, "index"]);
Route::post('/import/import', [GenerarCalculosExcel::class, "import"])->name("import");
