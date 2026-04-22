<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\admin\auth\ForgetPasswordController;
use App\Http\Controllers\admin\auth\ResetPasswordController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\admin\OptionController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\settings\AdminController;
use App\Http\Controllers\admin\settings\AdminGroupCategoryController;
use App\Http\Controllers\admin\settings\AdminGroupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');

    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::get('/forget-password',[ForgetPasswordController::class,'forgetPasswordForm'])->name('admin.forgetPassword');
    Route::post('/forget-password',[ForgetPasswordController::class,'sendEmailLink'])->name('admin.sendLink');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('reset.submit');


    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::resource('attributes', AttributeController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('options', OptionController::class);
        Route::resource('products', ProductController::class);

        Route::post('/load-option', [ProductController::class, 'loadOption'])->name('admin.load.option');

        Route::resource('coupons', CouponController::class);
        Route::prefix('settings')->group(function () {
            Route::resource('adminGroupCategories', AdminGroupCategoryController::class);
            Route::resource('adminGroups', AdminGroupController::class);
            Route::resource('admins',AdminController::class);
            Route::post('/admins/adminGroup',[AdminController::class,'adminGroup'])->name('admins.adminGroup');
        });

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'view'])->name('orders.view');
        Route::patch('/order/status/{id}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });
});
