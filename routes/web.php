<?php

use App\Http\Controllers\ActivationController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\CafeImageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeletionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MobileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::redirect('/', '/mobile/home');


Route::prefix('mobile')->group(function () {
    Route::get('/home', [MobileController::class, 'index']);
    Route::get('/discover', [MobileController::class, 'discover']);
    Route::get('/caffee/{name?}', [MobileController::class, 'show'])->name('caffee.show');
    Route::get('/open', [MobileController::class, 'open'])->name('caffee.open');
    Route::get('/open/form', [MobileController::class, 'openForm'])->name('caffe.open.form')->middleware('verified');
    Route::get('/favourite', [MobileController::class, 'fav'])->middleware('auth')->name('caffee.fav');
    Route::get('/profile', [MobileController::class, 'profile'])->middleware('auth')->name('profile');
    Route::get('/caffee/{name?}/menu', [MobileController::class, 'menu'])->name('caffee.menu');

    Route::get('/review/{cafe}', [MobileController::class, 'createReview'])->name('mobile.review.create');
    Route::post('/review/{cafe}', [MobileController::class, 'storeReview'])->name('mobile.review.store');

    Route::post('/caffe/fav', [MobileController::class, 'makeFav']);
    Route::post('/caffee', [CafeController::class, 'store']);
});

Route::prefix('admin')->as('admin.')->middleware(['auth', 'auth.admin'])->group(function () {
    Route::resource('review', ReviewController::class);
    Route::resource('report', ReportController::class);
    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('cafe', CafeController::class);
    Route::resource('activation', ActivationController::class);
    Route::resource('deletion', DeletionController::class);

    Route::get('/cafe/{cafe}/suspend', [CafeController::class, 'suspend'])->name('cafe.suspend');
    Route::get('/cafe/{cafe}/verify', [CafeController::class, 'verify'])->name('cafe.verify');

    Route::get('/user/{user}/suspend', [UserController::class, 'suspemd'])->name('user.suspend');
    Route::get('/user/{user}/verify', [UserController::class, 'verify'])->name('user.verify');

    Route::get('/', [HomeController::class, 'admin']);
});

Route::prefix('owner')->as('owner.')->middleware(['auth', 'auth.owner'])->group(function () {
    Route::resource('cafe', CafeController::class);
    Route::resource('cafe/{cafe}/review', ReviewController::class);
    Route::resource('cafe/{cafe}/url', UrlController::class);
    Route::resource('cafe/{cafe}/category', CategoryController::class);
    Route::resource('cafe/{cafe}/menu', MenuController::class);
    Route::resource('cafe/{cafe}/image', CafeImageController::class);
    Route::resource('cafe/{cafe}/activation', ActivationController::class);
    Route::resource('cafe/{cafe}/deletion', DeletionController::class);

    Route::get('cafe/{cafe}/activate', [CafeController::class, 'activate'])->name('cafe.activate');
    Route::get('cafe/{cafe}/image/{image}/pin', [CafeImageController::class, 'pin'])->name('image.pin');

    //reply review
    Route::post('cafe/{cafe}/review/reply', [ReviewController::class, 'reply'])->name('review.reply');

    Route::get('/', [HomeController::class, 'owner']);
    Route::get('/home', [HomeController::class, 'owner']);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('cafe', CafeController::class);
    Route::resource('review', ReviewController::class);

    Route::get('/user/notif/readall', [UserController::class, 'readAllNotif']);
});

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
