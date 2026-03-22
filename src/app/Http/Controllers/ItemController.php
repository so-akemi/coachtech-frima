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
    public function index(Request $request) 
    {
        $keyword = $request->get('keyword');
        $user = auth()->user();
        
        // タブの自動決定
        $tab = $request->get('tab', $user ? 'mylist' : 'recommend');

        $query = Item::query();

        // 検索フィルタリング
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        // 表示データの取得
        if ($tab === 'mylist') {
            $items = $user ? $user->favoriteItems()->where('items.name', 'like', '%' . $keyword . '%')->get() : collect();
        } else {
            if ($user) {
                $query->where('user_id', '!=', $user->id);
            }
            $items = $query->get();
        }

        return view('items.index', compact('items', 'tab'));
    }

    public function show($item_id) 
    {
        $item = Item::with('categories')->findOrFail($item_id);

        return view('items.show', compact('item'));
    }
    
    public function purchase($item_id) 
    {
        $item = Item::with('categories')->findOrFail($item_id);

        // セッションまたはデフォルト住所の取得
        $address = session("address_for_item_{$item_id}") ?? [
            'postal_code' => auth()->user()->postal_code ?? '',
            'address'     => auth()->user()->address ?? '',
            'building'    => auth()->user()->building ?? '',
        ];

        return view('purchase.index', compact('item', 'address'));
    }

    public function editAddress($item_id) 
    {
        $item = Item::findOrFail($item_id);

        return view('purchase.address', compact('item'));
    }

    public function updateAddress(AddressRequest $request, $item_id) 
    {
        // 入力値をセッションに保存
        session(["address_for_item_{$item_id}" => $request->only(['postal_code', 'address', 'building'])]);

        return redirect()->route('item.purchase', ['item_id' => $item_id]);
    }

    public function buy(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // 在庫チェック
        if (Order::where('item_id', $item_id)->exists()) {
            return back()->with('error', 'この商品は既に売り切れています。');
        }

        // Stripe決済準備
        Stripe::setApiKey(config('services.stripe.secret'));

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
            'success_url' => route('payment.success', ['item_id' => $item->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('item.purchase', ['item_id' => $item->id]),
            'metadata' => [
                'user_id' => auth()->id(),
                'item_id' => $item_id,
                'payment_method' => $request->payment_method,
            ],
        ]);

        return redirect($checkout_session->url);
    }

    public function success(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // 二重保存防止
        if (Order::where('item_id', $item_id)->exists()) {
             return redirect()->route('item.index');
        }
        
        $address = session("address_for_item_{$item_id}") ?? [
            'postal_code' => auth()->user()->postal_code,
            'address'     => auth()->user()->address,
            'building'    => auth()->user()->building,
        ];

        // 注文データの作成
        Order::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
            'payment_method' => 'カード払い',
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
        $categories = Category::all();

        return view('items.create', compact('categories'));
    }

    public function toggleFavorite($item_id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $user->favoriteItems()->toggle($item_id);

        return back();
    }
}