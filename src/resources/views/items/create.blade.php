@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="create-form__content">
    <div class="create-form__heading">
        <h1>商品の出品</h1>
    </div>

    <form action="{{ route('item.store') }}" method="POST" class="form" enctype="multipart/form-data">
        @csrf

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品画像</span>
            </div>
            <div class="form__group-content">
                <div class="form__image-upload-wrapper">
                    <label for="image" class="form__image-upload-label">
                        <span class="form__image-upload-button">画像を選択する</span>
                    </label>
                    <input type="file" name="image" id="image" accept="image/*" class="form__input--file-hidden">
                </div>
                
                <div class="form__error">
                    @error('image') {{ $message }} @enderror
                </div>
            </div>
        </div>

        <div class="form__group-section-title">
            <h2>商品の詳細</h2>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">カテゴリー</span>
            </div>
            <div class="form__group-content">
                @include('components.category-list')
                <div class="form__error">
                    @error('categories') {{ $message }} @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品の状態</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--select">
                    <select name="condition">
                        <option value="">選択してください</option>
                        @foreach(['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い'] as $cond)
                            <option value="{{ $cond }}" {{ old('condition') == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('condition') {{ $message }} @enderror
                </div>
            </div>
        </div>

        <div class="form__group-section-title">
            <h2>商品名と説明</h2>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>
                <div class="form__error">
                    @error('name') {{ $message }} @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">ブランド</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="brand" value="{{ old('brand') }}">
                </div>
                <div class="form__error">
                    @error('brand') {{ $message }} @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品の説明</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--textarea">
                    <textarea name="description">{{ old('description') }}</textarea>
                </div>
                <div class="form__error">
                    @error('description') {{ $message }} @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">販売価格</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--price">
                    <span class="form__currency">¥</span>
                    <input type="number" name="price" value="{{ old('price') }}">
                </div>
                <div class="form__error">
                    @error('price') {{ $message }} @enderror
                </div>
            </div>
        </div>

        <div class="form__button">
            <button class="form__button-submit" type="submit">出品する</button>
        </div>
    </form>
</div>
@endsection