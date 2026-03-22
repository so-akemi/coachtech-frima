@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
    <div class="address-content">
        <div class="address-heading">
            <h1>住所の変更</h1>
        </div>

        <form class="form" action="{{ route('address.update', ['item_id' => $item->id]) }}" method="POST">
            @csrf

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">郵便番号</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}">
                    </div>
                    @error('postal_code')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">住所</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="address" id="address" value="{{ old('address') }}">
                    </div>
                    @error('address')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">建物名</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="building" id="building" value="{{ old('building') }}">
                    </div>
                </div>
            </div>

            <div class="form-button">
                <button type="submit" class="form-button-submit">更新する</button>
            </div>
        </form>
    </div>
@endsection