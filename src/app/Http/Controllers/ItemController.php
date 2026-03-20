<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\Category;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request) {
        $keyword = $request->get('keyword'); // 検索キーワード取得
        $user = auth()->user();

        // URLパラメータに 'tab' がない場合、ログイン中なら 'mylist'、未ログインなら 'recommend' をデフォルトにする
        $tab = $request->get('tab');
        if (!$tab) {
        $tab = $user ? 'mylist' : 'recommend';
        }

        $query = Item::query();

        // FN016: 検索機能（商品名で部分一致）
        if ($keyword) {
        $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($tab === 'mylist') {
        // FN015: マイリスト（ログイン時のみ）
        $items = $user ? $user->favoriteItems()->where('name', 'like', '%' . $keyword . '%')->get() : collect();
        } else {
        // FN014: 全商品取得
        // FN014-4: 自分が出品した商品は表示しない
        if ($user) {
            $query->where('user_id', '!=', $user->id);
        }
        $items = $query->get();
        }

        return view('items.index', compact('items', 'tab'));
    }

    public function show($item_id) {
        $item = Item::with('categories')->findOrFail($item_id);
        return view('items.show', compact('item'));
    }
    
    public function purchase($item_id) {
        $item = Item::with('categories')->findOrFail($item_id);

        // 1. セッションに一時保存された住所があるか確認
        // なければ、ログインユーザーのデフォルト住所を使う
        $address = session("address_for_item_{$item_id}") ?? [
          'postal_code' => auth()->user()->postal_code ?? '', // ユーザーの郵便番号、なければ空文字
          'address'     => auth()->user()->address ?? '', // ユーザーの住所、なければ空文字
          'building'    => auth()->user()->building ?? '', // ユーザーの建物名、なければ空文字
        ];

        // 2. viewに $item と $address の両方を渡す
        return view('purchase.index', compact('item', 'address'));
    }

    public function editAddress($item_id) {
        $item = Item::findOrFail($item_id);
        return view('purchase.address', compact('item'));
    }

    public function updateAddress(AddressRequest $request, $item_id) {
        // 入力値をセッションに保存（'address_item_1' のように商品IDをキーにすると確実）
        session(["address_for_item_{$item_id}" => $request->only(['postal_code', 'address', 'building'])]);
        // ここで住所の更新処理を実装（例: ユーザーの住所情報を保存するなど）
        // 一旦、画面を戻す処理だけ書きます
        return redirect()->route('item.purchase', ['item_id' => $item_id]);
    }

    public function buy(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // 既に売り切れていないかチェック
        if (Order::where('item_id', $item_id)->exists()) {
            return back()->with('error', 'この商品は既に売り切れています。');
        }

        // Stripeのシークレットキーを設定
        Stripe::setApiKey(config('services.stripe.secret'));

        // Stripe Checkoutセッションの作成
        $checkout_session = Session::create([
            'payment_method_types' => ['card', 'konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            // 決済完了後のリダイレクト先（ successメソッドへ ）
            'success_url' => route('payment.success', ['item_id' => $item->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('item.purchase', ['item_id' => $item->id]),
            // 成功した時にDBに保存したい情報を metadata に隠し持つ
            'metadata' => [
                'user_id' => auth()->id(),
                'item_id' => $item_id,
                'payment_method' => $request->payment_method,
            ],
        ]);

        return redirect($checkout_session->url);
    }

    /**
     * ステップ2: 決済成功 -> アプリに戻ってきてDB保存
     */
    public function success(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // すでにOrderがある場合は二重保存を防止
        if (Order::where('item_id', $item_id)->exists()) {
             return redirect()->route('item.index');
        }

        // 本来はStripeのSessionを取得してmetadataを確認するのが確実ですが、
        // 学習用として、現在のセッションとリクエストから保存処理を行います。
        
        $address = session("address_for_item_{$item_id}") ?? [
            'postal_code' => auth()->user()->postal_code,
            'address'     => auth()->user()->address,
            'building'    => auth()->user()->building,
        ];

        // ここでDBに保存（元々 buy にあった処理をここに移動）
        Order::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
            'payment_method' => 'カード払い', // Stripe経由なので
            'postal_code' => $address['postal_code'],
            'address' => $address['address'],
            'building' => $address['building'],
        ]);

        // セッション消去
        session()->forget("address_for_item_{$item_id}");

        return redirect()->route('item.index')->with('message', 'ご購入ありがとうございました！');
    }

    public function create()
    {
        $categories = Category::all(); // DBから全カテゴリー取得
        return view('items.create', compact('categories'));
    }

    public function toggleFavorite($item_id)
    {
        $user = Auth::user();
        
        // ログインしていない場合はログイン画面へ
        if (!$user) {
            return redirect()->route('login');
        }

        // favoriteItems()リレーションを使って切り替え
        $user->favoriteItems()->toggle($item_id);

        return back();
    }
}
