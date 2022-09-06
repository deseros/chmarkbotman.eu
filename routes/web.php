<?php

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

Route::get('/', function () {
    return view('contact');
})->name('home');
Route::get('/coks', 'App\Http\Controllers\TgSettingsController@create_user');
Route::match(['get', 'post'], '/botman', 'App\Http\Controllers\BotManController@handle');
Route::post('/commentwebhook','App\Http\Controllers\BotComment\TelegramController@mywebhook');
Route::get('/botcomment', 'App\Http\Controllers\BotComment\TelegramController@setwebhook');
Route::get('/botmain', 'App\Http\Controllers\BotComment\TelegramController@setwebhookmain');
Route::get('/telegram_auth', 'App\Http\Controllers\Auth\SocialAuth@telegram_auth');
Route::post('/landing', 'App\Http\Controllers\MyContactForm@send');
Route::post('/logout_app', 'App\Http\Controllers\Auth\LogoutController@perform')->name('logout.perform');
Auth::routes(['register' => false]);

Route::get('/administrator', [App\Http\Controllers\HomeController::class, 'index'])->name('admin_auth');

Route::middleware(['role:admin'])->prefix('admin_lk')->group(function(){
 Route::get('/', 'App\Http\Controllers\Admin\AdminController@index')->name('homeAdmin');
 Route::resource('client', App\Http\Controllers\Admin\ClientController::class);
 Route::resource('tickets', App\Http\Controllers\Admin\TicketController::class);
 Route::resource('users', App\Http\Controllers\Admin\UsersController::class);
 Route::resource('tags', App\Http\Controllers\Admin\TagsController::class);
 Route::match(['get', 'post'], 'tgsettings', 'App\Http\Controllers\TgSettingsController@index')->name('tgsettings');
 Route::match(['get', 'post'], 'tgsettings/tgsendmessage', 'App\Http\Controllers\TgSettingsController@update_setting')->name('update_setting');
 //Route::resource('tgsettings', App\Http\Controllers\TgSettingsController::class);
});
