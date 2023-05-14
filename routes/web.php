<?php

use App\Http\Controllers\Frontend\FrontendController;
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

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('contact-us', [FrontendController::class, 'contactUs'])->name('contact.us');
Route::post('contact/message/send', [FrontendController::class, 'contactMessageSend'])->name('contact.message.send');

require __DIR__.'/admin.php';
