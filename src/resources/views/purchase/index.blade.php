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

        <div class="payment-method-section">
            <h3>支払い方法</h3>
            <div class="payment-select-wrapper">
                <select name="payment_method" id="payment_select" class="payment-input">
                    <option value="">選択してください</option>
                    @foreach(['コンビニ払い', 'カード払い'] as $method)
                        <option value="{{ $method }}" {{ old('payment_method') == $method ? 'selected' : '' }}>{{ $method }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="shipping-address">
            <div class="address-header">
                <h3>配送先</h3>
                <a href="{{ route('address.edit', ['item_id' => $item->id]) }}" class="change-link">変更する</a>
            </div>
            <p>〒 {{ $address['postal_code'] }}</p>
            <p>{{ $address['address'] }}</p>
            @if (!empty($address['building']))
             <p>{{ $address['building'] }}</p>
            @endif
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

            <form action="{{ route('item.buy', ['item_id' => $item->id]) }}" method="POST">
            @csrf
             <button type="submit" class="buy-submit-button">購入する</button>
            </form>
        </div>
    </div>
</div>
@endsection