<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\CommentController;

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

// 2. ログイン必須。ただし verified（メール認証）はここでは付けない
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');

    Route::get('/email/verify/manual', function () {
        $user = auth()->user();
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new \Illuminate\Auth\Events\Verified($user));
        }
        // 認証完了後、プロフィール設定画面へ
        return redirect()->route('profile.edit')->with('message', 'メール認証が完了しました。');
    })->name('verification.notice.manual');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/item/purchase/{item_id}', [ItemController::class, 'purchase'])->name('item.purchase');
   Route::get('/purchase/address/{item_id}', [ItemController::class, 'editAddress'])->name('address.edit');
   Route::post('/purchase/address/{item_id}', [ItemController::class, 'updateAddress'])->name('address.update');
   Route::post('/purchase/{item_id}', [ItemController::class, 'buy'])->name('item.buy');
   Route::get('/sell', [SellController::class, 'create'])->name('item.create');
   Route::post('/sell', [SellController::class, 'store'])->name('item.store');
   Route::post('/favorite/{item_id}', [ItemController::class, 'toggleFavorite'])->name('favorite.toggle');
   Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
   Route::get('/purchase/success/{item_id}', [ItemController::class, 'success'])->name('payment.success');
});