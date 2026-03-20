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
                    @if(str_starts_with($item->image_url, 'http'))
                    <!-- Excelの外部リンクの場合 -->
                      <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="item-detail__display-image">
                    @else
                      <!-- SellControllerでアップロードした場合 -->
                      <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" class="item-detail__display-image">
                    @endif
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
                <!-- form属性を追加して、離れた場所にあるformと一緒に送信されるようにします -->
                <select name="payment_method" id="payment_select" form="buy-form">
                    <option value="">選択してください</option>
                    @foreach(['コンビニ払い', 'カード払い'] as $method)
                        <option value="{{ $method }}" {{ old('payment_method') == $method ? 'selected' : '' }}>{{ $method }}</option>
                    @endforeach
                </select>
            </div>
            @error('payment_method')
                <p style="color: red; font-size: 0.8rem;">{{ $message }}</p>
            @enderror
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
                    <th>支払い方法</th>
                    <td id="display_payment_method">未選択</td>
                </tr>
            </table>

            <form action="{{ route('item.buy', ['item_id' => $item->id]) }}" method="POST" id="buy-form" class="purchase__buy-form">
                @csrf
                <input type="hidden" name="postal_code" value="{{ $address['postal_code'] }}">
                <input type="hidden" name="delivery_address" value="{{ $address['address'] }}">
                <input type="hidden" name="building" value="{{ $address['building'] }}">

                <div class="form__button">
                    <button type="submit" class="form__button-submit">購入する</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentSelect = document.getElementById('payment_select');
    const displayTarget = document.getElementById('display_payment_method');

    // 初期状態の反映（バリデーションエラーで戻ってきた時用）
    if (paymentSelect.value) {
        displayTarget.textContent = paymentSelect.options[paymentSelect.selectedIndex].text;
    }

    // 選択が変わった時の処理
    paymentSelect.addEventListener('change', function() {
        const selectedText = paymentSelect.options[paymentSelect.selectedIndex].text;
        displayTarget.textContent = (paymentSelect.value === "") ? "未選択" : selectedText;
    });
});
</script>
@endsection