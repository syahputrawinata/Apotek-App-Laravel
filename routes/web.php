<?php

use Illuminate\Support\Facades\Route;
// use: import file : namespace\namaclass\
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
// use App\Models\Medicine;

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

//diakses sebelum login
Route::middleware(['isGuest'])->group(function() {

Route::get('/', function() { 
    return view ('user.login'); 
})->name('login');

Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth'); 
});

//diakses setelah login
Route::middleware(['isLogin'])->group(function(){ 

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/home', function () {
    return view('home');
})->name('home');
    
Route::get('/user', function () {
    return view('user.index');
});

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// struktur routing laravel :
// Route::httpMethod('/nama-path', [namaController::class, 'namaFunc']) ->name
//('identitas_route');
// http method :
//1. get -> mengambil data/menampilkan halaman
//2. post -> menambahkan data baru ke db
//3. patch/put -> mengubah data yang sudah ada di db/ mengubah data di db
//4. delete -> menghapus data di db
Route::middleware(['isAdmin'])->group(function(){
    Route::prefix('/medicine')->name('medicine.')->group(function(){
        Route::get('/create', [MedicineController::class, 'create'])->name('create');
        Route::post('/store', [MedicineController::class, 'store'])->name('store');
        Route::get('/', [MedicineController::class, 'index'])->name('home');
        Route::get('/{id}', [MedicineController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [MedicineController::class, 'update'])->name('update');
        Route::delete('/{id}', [MedicineController::class, 'destroy'])->name('delete');
        Route::get('/data/stock', [MedicineController::class, 'stock'])->name('stock');
        Route::get('/data/stock/{id}', [MedicineController::class, 'stockEdit'])->name('stock.edit');
        Route::patch('/data/stock/{id}', [MedicineController::class, 'stockUpdate'])->name('stock.update');
    });

    Route::prefix('/user')->name('user.')->group(function(){
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/', [UserController::class, 'index'])->name('home');
        Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
    });
});

    // Route::get('/pembelian', [OrderController::class, 'index'])->name('pembelian');
    // Route::post('/create/pembelian', [OrderController::class, 'create'])->name('tambah.pembelian');
    Route::get('/download/{id}', [OrderController::class, 'downloadPdf'])->name('download');

    Route::middleware(['isLogin', 'isKasir'])->group(function() {
        Route::prefix('/kasir')->name('kasir.')->group(function() {
            Route::prefix('/order')->name('order.')->group(function() {
                Route::get('/', [OrderController::class, 'index'])->name('index');
                Route::get('/create', [OrderController::class, 'create'])->name('create');
                Route::post('/store', [OrderController::class, 'store'])->name('store');
                Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');
                Route::get('/download/{id}', [OrderController::class, 'downloadPdf'])->name('download');
            });
        });
    });
    
    Route::prefix('/order')->name('order.')->group(function(){
        Route::get('/data', [OrderController::class, 'data'])->name('data');
        Route::get('/export-excel', [OrderController::class, 'exportExcel'])->name('export-excel');
    });
    
}); 