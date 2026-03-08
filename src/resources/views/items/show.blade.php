@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="item-detail-container">
    <div class="item-image-section">
        <div class="image-wrapper">
            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="item-display-image">
        </div>
    </div>

    <div class="item-info-section">
        <h1 class="item-name">{{ $item->name }}</h1>
        <p class="brand-name">{{ $item->brand ?? 'ブランド名' }}</p>
        <p class="item-price">¥{{ number_format($item->price) }}<span>(税込)</span></p>

        <div class="item-stats">
            <div class="stat-item">
                <img src="{{ asset('/img/ハートロゴ_デフォルト.png') }}" alt="いいねアイコン" class="heart-icon-img">
                <p>3</p>
            </div>
            <div class="stat-item">
                <img src="{{ asset('/img/ふきだしロゴ.png') }}" alt="コメントアイコン" class="comment-icon-img">
                <p>1</p>
            </div>
        </div>

        <div class="buy-button">
          <a href="{{ route('item.purchase', ['item_id' => $item->id]) }}" class="buy-button-link">
          購入手続きへ
          </a>
        </div>

        <section class="detail-section">
            <h2 class="section-title">商品説明</h2>
            <div class="description-content">
                <p>カラー：グレー</p>
                <p>{{ $item->description }}</p>
            </div>
        </section>

        <section class="detail-section">
            <h2 class="section-title">商品の情報</h2>
            <div class="info-table">
                <div class="info-row">
                    <span class="info-label">カテゴリー</span>
                    <div class="category-tags">
                        @foreach($item->categories as $category)
                          <span class="category-tag">{{ $category->content }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="info-row">
                    <span class="info-label">商品の状態</span>
                    <span class="info-value">{{ $item->condition }}</span>
                </div>
            </div>
        </section>

        <section class="comment-section">
            <h2 class="section-title">コメント(1)</h2>
            <div class="comment-list">
                <div class="comment-user">
                    <div class="user-icon"></div>
                    <span class="user-name">admin</span>
                </div>
                <div class="comment-bubble">
                    ここにコメントが入ります。
                </div>
            </div>

            <form class="comment-form">
                <label class="comment-label">商品へのコメント</label>
                <textarea class="comment-textarea"></textarea>
                <button type="submit" class="comment-submit">コメントを送信する</button>
            </form>
        </section>
    </div>
</div>
@endsection