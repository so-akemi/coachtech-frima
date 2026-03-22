@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
    <div class="item-detail-container">
        <div class="item-detail-image-section">
            <div class="item-detail-image-wrapper">
                @if($item->order)
                    <div class="item-sold-badge">Sold</div>
                @endif

                @if(str_starts_with($item->image_url, 'http'))
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="item-detail-display-image">
                @else
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" class="item-detail-display-image">
                @endif
            </div>
        </div>

        <div class="item-detail-info-section">
            <h1 class="item-detail-name">{{ $item->name }}</h1>
            <p class="item-detail-brand">{{ $item->brand ?? 'ブランド名' }}</p>
            <p class="item-detail-price">¥{{ number_format($item->price) }}<span>(税込)</span></p>

            <div class="item-detail-stats">
                <div class="item-detail-stat-item">
                    <form action="{{ route('favorite.toggle', ['item_id' => $item->id]) }}" method="POST">
                        @csrf
                        <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                            @if(Auth::check() && Auth::user()->favoriteItems->contains($item->id))
                                <img src="{{ asset('/img/ハートロゴ_ピンク.png') }}" alt="いいね解除" class="item-detail-icon">
                            @else
                                <img src="{{ asset('/img/ハートロゴ_デフォルト.png') }}" alt="いいね登録" class="item-detail-icon">
                            @endif
                        </button>
                    </form>
                    <p>{{ $item->favorites()->count() }}</p>
                </div>

                <div class="item-detail-stat-item">
                    <div class="item-detail-comment-icon-wrapper">
                        <img src="{{ asset('/img/ふきだしロゴ.png') }}" alt="コメント" class="item-detail-icon">
                    </div>
                    <p>{{ $item->comments->count() }}</p>
                </div>
            </div>

            <div class="item-detail-buy-action">
                @if($item->order)
                    <button class="item-detail-buy-button" disabled>購入手続きへ</button>
                @else
                    <a href="{{ route('item.purchase', ['item_id' => $item->id]) }}" class="item-detail-buy-button">
                        購入手続きへ
                    </a>
                @endif
            </div>

            <section class="item-detail-section">
                <h2 class="item-detail-section-title">商品説明</h2>
                <div class="item-detail-description">
                    <p>{{ $item->description }}</p>
                </div>
            </section>

            <section class="item-detail-section">
                <h2 class="item-detail-section-title">商品の情報</h2>
                <div class="item-detail-info-table">
                    <div class="item-detail-info-row">
                        <span class="item-detail-info-label">カテゴリー</span>
                        <div class="item-detail-category-tags">
                            @foreach($item->categories as $category)
                                <span class="item-detail-category-tag">{{ $category->content }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="item-detail-info-row">
                        <span class="item-detail-info-label">商品の状態</span>
                        <span class="item-detail-info-value">{{ $item->condition }}</span>
                    </div>
                </div>
            </section>

            <section class="item-detail-comment-section">
                <h2 class="item-detail-section-title">コメント({{ $item->comments->count() }})</h2>

                <div class="item-detail-comment-list">
                    @foreach($item->comments as $comment)
                        <div class="item-detail-comment-item">
                            <div class="item-detail-comment-user">
                                <div class="item-detail-user-icon">
                                    @if($comment->user->image_url)
                                        <img src="{{ asset($comment->user->image_url) }}" alt="">
                                    @endif
                                </div>
                                <span class="item-detail-user-name">{{ $comment->user->name }}</span>
                            </div>
                            <div class="item-detail-comment-bubble">
                                {{ $comment->content }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <form action="{{ route('comment.store') }}" method="POST" class="item-detail-comment-form" novalidate>
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">

                    <div class="form-group">
                        <div class="form-group-title">
                            <span class="form-label-item">商品へのコメント</span>
                        </div>
                        <div class="form-group-content">
                            <div class="form-input-textarea">
                                <textarea name="content" required></textarea>
                            </div>
                            @error('content')
                                <p class="error-message" style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-button">
                        @auth
                            <button type="submit" class="form-button-submit">コメントを送信する</button>
                        @else
                            <a href="{{ route('login') }}" class="form-button-submit">コメントを送信する</a>
                        @endauth
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection
