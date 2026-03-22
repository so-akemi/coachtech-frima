@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="mypage-content">
        <div class="mypage-user-profile">
            <div class="mypage-user-info-flex">
                <div class="mypage-user-avatar">
                    <div class="mypage-avatar-circle">
                        @if($user->image_url)
                            <img src="{{ asset('storage/' . $user->image_url) }}" alt="" class="mypage-avatar-img">
                        @endif
                    </div>
                </div>
                <h1 class="mypage-user-name">{{ $user->name }}</h1>
                <div class="mypage-edit-action">
                    <a href="{{ route('profile.edit') }}" class="mypage-edit-button">プロフィールを編集</a>
                </div>
            </div>
        </div>

        <div class="mypage-tab-menu">
            <a href="{{ route('profile.index', ['page' => 'sell']) }}" 
               class="mypage-tab-item {{ $currentPage !== 'buy' ? 'mypage-tab-item-active' : '' }}">
                出品した商品
            </a>
            <a href="{{ route('profile.index', ['page' => 'buy']) }}" 
               class="mypage-tab-item {{ $currentPage === 'buy' ? 'mypage-tab-item-active' : '' }}">
                購入した商品
            </a>
        </div>

        <div class="mypage-product-grid">
            @if($currentPage === 'buy')
                @forelse($buyItems as $item)
                    <div class="mypage-product-card">
                        <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                            <div class="mypage-product-image-container">
                                @if(str_starts_with($item->image_url, 'http'))
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                                @endif

                                @if($item->order) 
                                    <div class="mypage-sold-badge">
                                        <span class="mypage-sold-text">Sold</span>
                                    </div>
                                @endif
                            </div>
                            <p class="mypage-product-name">{{ $item->name }}</p>
                        </a>
                    </div>
                @empty
                    <p class="mypage-empty-message">購入した商品はありません</p>
                @endforelse
            @else
                @forelse($sellItems as $item)
                    <div class="mypage-product-card">
                        <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                            <div class="mypage-product-image-container">
                                @if(str_starts_with($item->image_url, 'http'))
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                                @endif
                            </div>
                            <p class="mypage-product-name">{{ $item->name }}</p>
                        </a>
                    </div>
                @empty
                    <p class="mypage-empty-message">出品した商品はありません</p>
                @endforelse
            @endif
        </div>
    </div>
@endsection