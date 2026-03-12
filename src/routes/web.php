<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellController;

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

Route::get('/', [ItemController::class, 'index'])->name('item.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');


Route::middleware('auth')->group(function () {
    Route::get('/item/purchase/{item_id}', [ItemController::class, 'purchase'])->name('item.purchase');
   Route::get('/purchase/address/{item_id}', [ItemController::class, 'editAddress'])->name('address.edit');
   Route::post('/purchase/address/{item_id}', [ItemController::class, 'updateAddress'])->name('address.update');
   Route::post('/purchase/{item_id}', [ItemController::class, 'buy'])->name('item.buy');
   // マイページトップ（プロフィールと出品・購入一覧）
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');
   // プロフィール設定画面（初回登録時・編集時）
   Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
   // プロフィール更新処理
   Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
   Route::get('/sell', [SellController::class, 'create'])->name('item.create');
   Route::post('/sell', [SellController::class, 'store'])->name('item.store');
   Route::post('/favorite/{item_id}', [ItemController::class, 'toggleFavorite'])->name('favorite.toggle');
   Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
});