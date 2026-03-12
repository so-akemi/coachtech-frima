@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase__container">
    <div class="purchase__left">
        <div class="purchase__item-confirm">
            <div class="purchase__item-info">
                <div class="purchase__item-image">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                </div>
                <div class="purchase__item-text">
                    <p class="purchase__item-name">{{ $item->name }}</p>
                    <p class="purchase__item-price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>
        </div>

        <div class="purchase__section">
            <div class="purchase__section-title">
                <h3>支払い方法</h3>
            </div>
            <div class="form__input--select">
                <select name="payment_method" id="payment_select">
                    <option value="">選択してください</option>
                    @foreach(['コンビニ払い', 'カード払い'] as $method)
                        <option value="{{ $method }}" {{ old('payment_method') == $method ? 'selected' : '' }}>{{ $method }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="purchase__section">
            <div class="purchase__address-header">
                <h3>配送先</h3>
                <a href="{{ route('address.edit', ['item_id' => $item->id]) }}" class="purchase__change-link">変更する</a>
            </div>
            <div class="purchase__address-content">
                <p>〒 {{ $address['postal_code'] }}</p>
                <p>{{ $address['address'] }}</p>
                @if (!empty($address['building']))
                    <p>{{ $address['building'] }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="purchase__right">
        <div class="purchase__summary-box">
            <table class="purchase__summary-table">
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
                    <td id="display_payment_method">未選択</td>
                </tr>
            </table>

            <form action="{{ route('item.buy', ['item_id' => $item->id]) }}" method="POST" class="purchase__buy-form">
                @csrf
                <div class="form__button">
                    <button type="submit" class="form__button-submit">購入する</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection