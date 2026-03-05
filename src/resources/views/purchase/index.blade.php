@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <div class="purchase-left">
        <div class="item-confirm">
            <div class="item-info">
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="confirm-image">
                <div class="item-text">
                    <p class="confirm-name">{{ $item->name }}</p>
                    <p class="confirm-price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>
        </div>

        <div class="payment-method">
            <h3>支払い方法</h3>
            <a href="#" class="change-link">変更する</a>
        </div>

        <div class="shipping-address">
            <div class="address-header">
                <h3>配送先</h3>
                <a href="{{ route('address.edit', ['item_id' => $item->id]) }}" class="change-link">変更する</a>
            </div>
            <p>〒 123-4567</p>
            <p>東京都〇〇区△△ 1-2-3</p>
        </div>
    </div>

    <div class="purchase-right">
        <div class="summary-box">
            <table class="summary-table">
                <tr>
                    <th>商品代金</th>
                    <td>¥{{ number_format($item->price) }}</td>
                </tr>
                <tr>
                    <th>支払い金額</th>
                    <td>¥{{ number_format($item->price) }}</td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td>コンビニ払い</td>
                </tr>
            </table>
            <button class="buy-submit-button">購入する</button>
        </div>
    </div>
</div>
@endsection