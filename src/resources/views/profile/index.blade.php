@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="mypage__content">
    <div class="mypage__user-profile">
        <div class="mypage__user-info-flex">
            <div class="mypage__user-avatar">
                <div class="mypage__avatar-circle"></div>
            </div>
            <h2 class="mypage__user-name">{{ $user->name }}</h2>
            <div class="mypage__edit-action">
                <a href="{{ route('profile.edit') }}" class="mypage__edit-button">プロフィールを編集</a>
            </div>
        </div>
    </div>

    <div class="mypage__tab-menu">
        <a href="{{ route('profile.index', ['page' => 'sell']) }}" 
           class="mypage__tab-item {{ $currentPage !== 'buy' ? 'mypage__tab-item--active' : '' }}">
           出品した商品
        </a>
        <a href="{{ route('profile.index', ['page' => 'buy']) }}" 
           class="mypage__tab-item {{ $currentPage === 'buy' ? 'mypage__tab-item--active' : '' }}">
           購入した商品
        </a>
    </div>

    <div class="mypage__product-grid">
        @if($currentPage === 'buy')
            @forelse($buyItems as $item)
                <div class="mypage__product-card">
                    <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                        <div class="mypage__product-image-container">
                            <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                        </div>
                        <p class="mypage__product-name">{{ $item->name }}</p>
                    </a>
                </div>
            @empty
                <p class="mypage__empty-message">購入した商品はありません</p>
            @endforelse
        @else
            @forelse($sellItems as $item)
                <div class="mypage__product-card">
                    <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                        <div class="mypage__product-image-container">
                            <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                        </div>
                        <p class="mypage__product-name">{{ $item->name }}</p>
                    </a>
                </div>
            @empty
                <p class="mypage__empty-message">出品した商品はありません</p>
            @endforelse
        @endif
    </div>
</div>
@endsection