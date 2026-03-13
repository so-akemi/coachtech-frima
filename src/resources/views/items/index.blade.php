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
                    <!-- 条件分岐を追加：httpで始まればそのまま、そうでなければstorageから取得 -->
                      @if(str_starts_with($item->image_url, 'http'))
                         <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="index__product-image">
                      @else
                         <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" class="index__product-image">
                      @endif
                      @else
                         <span style="color: #666;">商品画像</span>
                    @endif
                    @if($item->order) 
                        <div class="index__sold-badge">
                          <span class="index__sold-text">Sold</span>
                        </div>
                    @endif
                </div>
                <p class="index__product-name">{{ $item->name }}</p>
            </a>
        @endforeach
    </div>
</div>
@endsection