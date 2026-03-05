@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address-container">
    <h2 class="page-title">住所の変更</h2>

    <form action="{{ route('address.update', ['item_id' => $item->id]) }}" method="POST" class="address-form">
        @csrf
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" class="form-input">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" class="form-input">
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" class="form-input">
        </div>

        <button type="submit" class="update-button">更新する</button>
    </form>
</div>
@endsection