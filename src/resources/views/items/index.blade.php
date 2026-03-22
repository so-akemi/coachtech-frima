@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="index-content">
        <div class="index-tab-menu">
            <a href="{{ route('item.index', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}" 
               class="{{ $tab !== 'mylist' ? 'index-tab-item-active' : 'index-tab-item' }}">
                おすすめ
            </a>
            
            <a href="{{ route('item.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}" 
               class="{{ $tab === 'mylist' ? 'index-tab-item-active' : 'index-tab-item' }}">
                マイリスト
            </a>
        </div>

        <div class="index-product-grid">
            @foreach($items as $item)
                <a href="{{ route('item.show', ['item_id' => $item->id]) }}" class="index-product-card">
                    <div class="index-product-image-container">
                        @if($item->image_url)
                            @if(str_starts_with($item->image_url, 'http'))
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="index-product-image">
                            @else
                                <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" class="index-product-image">
                            @endif
                        @else
                            <div class="index-product-no-image">
                                <span>商品画像</span>
                            </div>
                        @endif

                        @if($item->order) 
                            <div class="index-sold-badge">
                                <span class="index-sold-text">Sold</span>
                            </div>
                        @endif
                    </div>
                    
                    <p class="index-product-name">{{ $item->name }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endsection