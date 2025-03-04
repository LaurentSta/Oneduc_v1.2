<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\CategoryController;


// Route::get('/', function () {
//    return view('welcome');
// });

Route::get('/', [UserController::class, 'Index'])->name('index');
Route::get('/le-projet-oneduc-fr', [UserController::class, 'Projet'])->name('projet');
Route::get('/association', [UserController::class, 'Association'])->name('association');
Route::get('/adhesion', [UserController::class, 'Adhesion'])->name('adhesion');
Route::get('/connexion', [AdminController::class, 'Login'])->name('connexion');
Route::get('/inscription', [UserController::class, 'Register'])->name('inscription');
Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
Route::get('/user/parametre', [UserController::class, 'UserParametre'])->name('user.parametre');
Route::post('/user/profil/store', [UserController::class, 'UserProfilStore'])->name('user.profil.store');
Route::get('/user/securite', [UserController::class, 'showUserSecurite'])->name('user.securite.show');




Route::get('/dashboard', function () {
    return view('frontend.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
        Route::middleware(['auth', 'role:admin'])->group(function () {
            Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
            Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
            Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
            Route::get('/admin/parametre', [AdminController::class, 'AdminParametre'])->name('admin.parametre');
            Route::post('/admin/profil/store', [AdminController::class, 'AdminProfilStore'])->name('admin.profil.store');
            Route::get('/admin/securite', [AdminController::class, 'showAdminSecurite'])->name('admin.securite.show');
            Route::post('/admin/securite', [AdminController::class, 'AdminSecurite'])->name('admin.securite');

            // Toutes les Routes de catégorie
            // Category All Route
            Route::controller(CategoryController::class)->group(function(){
                Route::get('/all/category','AllCategory')->name('all.category');
                Route::get('/add/category','AddCategory')->name('add.category');
                Route::post('/store/category','StoreCategory')->name('store.category');
                Route::get('/edit/category/{id}','EditCategory')->name('edit.category');
                Route::post('/update/category','UpdateCategory')->name('update.category');
                Route::get('/delete/category/{id}','DeleteCategory')->name('delete.category');

            });
            // Instructor All Route
            Route::controller(AdminController::class)->group(function(){
                Route::get('/all/instructor','AllInstructor')->name('all.instructor');
                Route::post('/update/user/stauts','UpdateUserStatus')->name('update.user.status');


            });
        });// End Admin Group Middleware

Route::get('/become/instructor', [AdminController::class, 'BecomeInstructor'])->name('become.instructor');
Route::post('/instructor/register', [AdminController::class, 'InstructorRegister'])->name('instructor.register');

Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'InstructorDashboard'])->name('instructor.dashboard');
    Route::get('/instructor/logout', [InstructorController::class, 'InstructorLogout'])->name('instructor.logout');
    Route::get('/instructor/profile', [InstructorController::class, 'InstructorProfile'])->name('instructor.profile');
    Route::get('/instructor/parametre', [InstructorController::class, 'InstructorParametre'])->name('instructor.parametre');
    Route::post('/instructor/profil/store', [InstructorController::class, 'InstructorProfilStore'])->name('instructor.profil.store');
    Route::get('/instructor/securite', [InstructorController::class, 'showInstructorSecurite'])->name('instructor.securite.show');
});



require __DIR__.'/auth.php';
