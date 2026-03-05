@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection
@section('content')
<div class="tab-menu">
    <a href="#" class="tab-item active">おすすめ</a>
    <a href="#" class="tab-item">マイリスト</a>
</div>

<div class="product-grid">
    @foreach($items as $item)
        <a href="{{ route('item.show', ['item_id' => $item->id]) }}" class="product-card">
            <div class="product-image-container">
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="product-image">
            </div>
            <p class="product-name">{{ $item->name }}</p>
        </a>
    @endforeach
</div>
@endsection