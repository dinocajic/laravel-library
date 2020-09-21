<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CheckinBookController;
use App\Http\Controllers\CheckoutBookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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
Route::post('/books',          [BookController::class, 'store'])->name('books.store');
Route::patch('/books/{book}',  [BookController::class, 'update'])->name('books.update');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

Route::post('/authors', [AuthorController::class, 'store'])->name('author.store');

Route::post('/checkout/{book}', [CheckoutBookController::class, 'store'])->name('checkout.store');

Route::post('/checkin/{book}', [CheckinBookController::class, 'store'])->name('checkin.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
