@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase-container">
        <div class="purchase-left">
            <div class="purchase-item-confirm">
                <div class="purchase-item-info">
                    <div class="purchase-item-image">
                        @if (str_starts_with($item->image_url, 'http'))
                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="purchase-display-image">
                        @else
                            <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}"
                                class="purchase-display-image">
                        @endif
                    </div>
                    <div class="purchase-item-text">
                        <p class="purchase-item-name">{{ $item->name }}</p>
                        <p class="purchase-item-price">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>
            </div>

            <div class="purchase-section">
                <div class="purchase-section-title">
                    <h3>支払い方法</h3>
                </div>
                <div class="form-input-select">
                    <select name="payment_method" id="payment_select" form="buy-form">
                        <option value="">選択してください</option>
                        @foreach (['コンビニ払い', 'カード払い'] as $method)
                            <option value="{{ $method }}" {{ old('payment_method') == $method ? 'selected' : '' }}>
                                {{ $method }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-error">
                    @error('payment_method')
                        {{ $message }}
                    @enderror
                </div>

            </div>

            <div class="purchase-section">
                <div class="purchase-address-header">
                    <h3>配送先</h3>
                    <a href="{{ route('address.edit', ['item_id' => $item->id]) }}" class="purchase-change-link">変更する</a>
                </div>
                <div class="purchase-address-content">
                    <p>〒 {{ $address['postal_code'] }}</p>
                    <p>{{ $address['address'] }}</p>
                    @if (!empty($address['building']))
                        <p>{{ $address['building'] }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="purchase-right">
            <div class="purchase-summary-box">
                <table class="purchase-summary-table">
                    <tr>
                        <th>商品代金</th>
                        <td>¥{{ number_format($item->price) }}</td>
                    </tr>
                    <tr>
                        <th>支払い方法</th>
                        <td id="display_payment_method">未選択</td>
                    </tr>
                </table>

                <form action="{{ route('item.buy', ['item_id' => $item->id]) }}" method="POST" id="buy-form"
                    class="purchase-buy-form">
                    @csrf
                    <input type="hidden" name="postal_code" value="{{ $address['postal_code'] }}">
                    <input type="hidden" name="delivery_address" value="{{ $address['address'] }}">
                    <input type="hidden" name="building" value="{{ $address['building'] }}">

                    <div class="form-button">
                        <button type="submit" class="form-button-submit">購入する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentSelect = document.getElementById('payment_select');
            const displayTarget = document.getElementById('display_payment_method');

            if (paymentSelect.value) {
                displayTarget.textContent = paymentSelect.options[paymentSelect.selectedIndex].text;
            }

            paymentSelect.addEventListener('change', function() {
                const selectedText = paymentSelect.options[paymentSelect.selectedIndex].text;
                displayTarget.textContent = (paymentSelect.value === "") ? "未選択" : selectedText;
            });
        });
    </script>
@endsection
