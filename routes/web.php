<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UploadController;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Clas;

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

Route::get('/', function () {
    $users =  User::all()->count();
    $categoury = Equipment::all()->count();
    $class = Clas::all()->count();
    return view('admin.dashboard',compact('users','class','categoury'));
})->middleware(['auth']);


Route::middleware('auth')->group(function () {

    //=================================user routes =====================================
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/add_users' , [AdminController::class, 'show_user_form'])->name('userform');
    Route::post('/add_users' , [AdminController::class, 'add_users'])->name('add_users');
    Route::get('/edit_user/{id}' , [AdminController::class, 'edit_user'])->name('edit_user');
    Route::post('/update_user/{id}' , [AdminController::class, 'update_user'])->name('update_user');
    Route::delete('/delete_user' , [AdminController::class, 'delete_user'])->name('delete_user');

    //=====================================licence Routes==========================================
    Route::get('/licence' , [AdminController::class, 'licence'])->name('licence');
    Route::post('/add_licence' , [AdminController::class, 'add_licence'])->name('add_licence');
    Route::get('/edit_licence/{id}' , [AdminController::class, 'edit_licence'])->name('edit_licence');
    Route::PUT('/licence_update' , [AdminController::class, 'licence_update'])->name('licence_update');
    Route::delete('/licence_delete' , [AdminController::class, 'licence_delete'])->name('licence_delete');



    Route::post('/upload', [UploadController::class, 'store']);
    Route::get('/admin_logout', [AdminController::class, 'logout'])->name('admin_logout');

    //========================Equipments Routes =========================================
    Route::get('/equipments', [AdminController::class, 'eqp'])->name('equipments');
    Route::get('/add_equipments', [AdminController::class, 'add_eqp_show'])->name('show_add_equipments');
    Route::post('/add_equipments', [AdminController::class, 'add_eqp'])->name('add_equipments');
    Route::get('/edit_equipment/{id}' , [AdminController::class, 'edit_equipment'])->name('edit_equipment');
    Route::post('/update_equipment/{id}' , [AdminController::class, 'update_equipment'])->name('update_equipment');
    Route::delete('/equipment_delete' , [AdminController::class, 'equipment_delete'])->name('equipment_delete');

    //=============================Classes Routes ==========================================
    Route::get('/classes', [AdminController::class, 'clas'])->name('classes');
    Route::get('/add_class', [AdminController::class, 'add_clas_show'])->name('show_add_class');
    Route::post('/add_class', [AdminController::class, 'add_clas'])->name('add_class');
    Route::get('/edit_class/{id}' , [AdminController::class, 'edit_class'])->name('edit_class');
    Route::post('/update_class/{id}' , [AdminController::class, 'update_class'])->name('update_class');
    Route::delete('/class_delete' , [AdminController::class, 'class_delete'])->name('class_delete');

     //=============================Ratings And Reviews Routes ========================================
     Route::get('/ratings', [AdminController::class, 'ratings'])->name('ratings');
     Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
});

Route::get('/dashboard', function () {
    $users =  User::all()->count();
    $categoury = Equipment::all()->count();
    $class = Clas::all()->count();
    return view('admin.dashboard',compact('users','class','categoury'));
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
