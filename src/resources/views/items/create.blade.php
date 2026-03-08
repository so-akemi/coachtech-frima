@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="create-form__content">
    <h1 class="create-form__heading">商品の出品</h1>

    <form action="{{ route('item.store') }}" method="POST" class="create-form" enctype="multipart/form-data">
        @csrf

        <!-- 1. 商品画像（これが抜けていました！） -->
        <div class="form-group">
            <div class="form-group-item">
                <label>商品画像</label>
                <div class="image-upload-box">
                    <input type="file" name="image" id="image">
                </div>
                <div class="form-error">
                 @error('image')
                  <p class="error-msg">{{ $message }}</p>
                 @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="form-group-title">
                <h2>商品の詳細</h2>
            </div>
            <!-- 2. カテゴリー（先ほど作成した共通パーツを読み込む） -->
            <div class="form-group-item">
                <label>カテゴリー</label>
                <div class="category-selection">
                    @include('components.category-list')
                </div>
                <div class="form-error">
                @error('categories')
                 <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <div class="form-group-item">
                <label>商品の状態</label>
            </div>
            <div class="form-group-category">
                <!-- old() を使うと、入力ミスで戻ってきた時に選択が維持されます -->
                <select name="condition" class="form-input">
                    <option value="">選択してください</option>
                    @foreach(['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い'] as $cond)
                        <option value="{{ $cond }}" {{ old('condition') == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                    @endforeach
                </select>
                <div class="form-error">
                 @error('condition')
                  <p class="error-msg">{{ $message }}</p>
                 @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="form-group-title">
                <h2>商品名と説明</h2>
            </div>
            <div class="form-group-item">
                <label for="name">商品名</label>
                <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}">
                
                <div class="form-error">
                 @error('name')
                  <p class="error-msg">{{ $message }}</p>
                 @enderror
                </div>
            </div>

            <div class="form-group-item">
                <label for="brand">ブランド</label>
                <input type="text" name="brand" id="brand" class="form-input" value="{{ old('brand') }}">
                <div class="form-error">
                 @error('brand')
                  <p class="error-msg">{{ $message }}</p>
                 @enderror
                </div>
            </div>
            <div class="form-group-item">
                <label for="description">商品の説明</label>
                <textarea name="description" id="description" class="form-input">{{ old('description') }}</textarea>
                <div class="form-error">
                 @error('description')
                  <p class="error-msg">{{ $message }}</p>
                 @enderror
                </div>
            </div>
            <div class="form-group-item">
                <label for="price">販売価格</label>
                <div class="price-input-wrapper">
                    <span class="currency-unit">¥</span>
                    <input type="number" name="price" id="price" class="form-input" value="{{ old('price') }}">
                </div>
                <div class="form-error">
                 @error('price')
                  <p class="error-msg">{{ $message }}</p>
                 @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="create-button">出品する</button>
    </form>
</div>
@endsection