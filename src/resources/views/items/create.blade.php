@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
    <div class="create-form-content">
        <div class="create-form-heading">
            <h1>商品の出品</h1>
        </div>

        <form action="{{ route('item.store') }}" method="POST" class="form" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">商品画像</span>
                </div>
                <div class="form-group-content">
                    <div class="form-image-upload-wrapper">
                        <label for="image" class="form-image-upload-label">
                            <span class="form-image-upload-button">画像を選択する</span>
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" class="form-input-file-hidden">
                    </div>

                    <div class="form-error">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group-section-title">
                <h2>商品の詳細</h2>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">カテゴリー</span>
                </div>
                <div class="form-group-content">
                    @include('components.category-list')
                    <div class="form-error">
                        @error('categories')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">商品の状態</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-select">
                        <select name="condition">
                            <option value="">選択してください</option>
                            @foreach(['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い'] as $cond)
                                <option value="{{ $cond }}" {{ old('condition') == $cond ? 'selected' : '' }}>
                                    {{ $cond }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-error">
                        @error('condition')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group-section-title">
                <h2>商品名と説明</h2>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">商品名</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-error">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">ブランド</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="brand" value="{{ old('brand') }}">
                    </div>
                    <div class="form-error">
                        @error('brand')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">商品の説明</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-textarea">
                        <textarea name="description">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-error">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">販売価格</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-price">
                        <span class="form-currency">¥</span>
                        <input type="number" name="price" value="{{ old('price') }}">
                    </div>
                    <div class="form-error">
                        @error('price')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-button">
                <button class="form-button-submit" type="submit">出品する</button>
            </div>
        </form>
    </div>
@endsection
