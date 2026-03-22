<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 公開ページ
Route::get('/', [ItemController::class, 'index'])->name('item.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

// --- ログイン必須のルート ---
Route::middleware(['auth'])->group(function () {
    
    // プロフィール関連
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 手動メール認証（開発・テスト用）
    Route::get('/email/verify/manual', function () {
        $user = auth()->user();
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new \Illuminate\Auth\Events\Verified($user));
        }
        return redirect()->route('profile.edit')->with('message', 'メール認証が完了しました。');
    })->name('verification.notice.manual');
    
});

// --- ログイン ＋ メール認証済みのルート ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 購入・決済関連
    Route::get('/item/purchase/{item_id}', [ItemController::class, 'purchase'])->name('item.purchase');
    Route::get('/purchase/address/{item_id}', [ItemController::class, 'editAddress'])->name('address.edit');
    Route::post('/purchase/address/{item_id}', [ItemController::class, 'updateAddress'])->name('address.update');
    Route::post('/purchase/{item_id}', [ItemController::class, 'buy'])->name('item.buy');
    Route::get('/purchase/success/{item_id}', [ItemController::class, 'success'])->name('payment.success');

    // 出品関連
    Route::get('/sell', [SellController::class, 'create'])->name('item.create');
    Route::post('/sell', [SellController::class, 'store'])->name('item.store');

    // お気に入り・コメント
    Route::post('/favorite/{item_id}', [ItemController::class, 'toggleFavorite'])->name('favorite.toggle');
    Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');

});