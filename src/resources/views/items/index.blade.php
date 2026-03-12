@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="index__content">
    <div class="index__tab-menu">
        <!-- tabパラメータがない、または 'index' の時に赤くなる -->
        <a href="{{ route('item.index') }}" 
           class="{{ request('tab') !== 'mylist' ? 'index__tab-item--active' : 'index__tab-item' }}">
           おすすめ
        </a>
        
        <!-- tabパラメータが 'mylist' の時に赤くなる -->
        <a href="{{ route('item.index', ['tab' => 'mylist']) }}" 
           class="{{ request('tab') === 'mylist' ? 'index__tab-item--active' : 'index__tab-item' }}">
           マイリスト
        </a>
    </div>

    <div class="index__product-grid">
        @foreach($items as $item)
            <a href="{{ route('item.show', ['item_id' => $item->id]) }}" class="index__product-card">
                <div class="index__product-image-container">
                    @if($item->image_url)
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="index__product-image">
                    @else
                        <!-- 画像がない場合のプレースホルダー -->
                        <span style="color: #666;">商品画像</span>
                    @endif
                </div>
                <p class="index__product-name">{{ $item->name }}</p>
            </a>
        @endforeach
    </div>
</div>
@endsection