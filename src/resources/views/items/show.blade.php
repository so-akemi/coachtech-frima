@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="item-detail__container">
    <div class="item-detail__image-section">
        <div class="item-detail__image-wrapper">
            @if(str_starts_with($item->image_url, 'http'))
            <!-- Excelの外部リンクの場合 -->
              <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="item-detail__display-image">
            @else
            <!-- SellControllerでアップロードした場合 -->
              <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" class="item-detail__display-image">
            @endif
        </div>
    </div>

    <div class="item-detail__info-section">
        <h1 class="item-detail__name">{{ $item->name }}</h1>
        <p class="item-detail__brand">{{ $item->brand ?? 'ブランド名' }}</p>
        <p class="item-detail__price">¥{{ number_format($item->price) }}<span>(税込)</span></p>

        <div class="item-detail__stats">
            <div class="item-detail__stat-item">
                <form action="{{ route('favorite.toggle', ['item_id' => $item->id]) }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                        @if(Auth::check() && Auth::user()->favoriteItems->contains($item->id))
                            <img src="{{ asset('/img/ハートロゴ_ピンク.png') }}" alt="いいね解除" class="item-detail__icon">
                        @else
                            <img src="{{ asset('/img/ハートロゴ_デフォルト.png') }}" alt="いいね登録" class="item-detail__icon">
                        @endif
                    </button>
                </form>
                <p>{{ $item->favorites()->count() }}</p>
            </div>

            <div class="item-detail__stat-item">
                <div class="item-detail__comment-icon-wrapper">
                    <img src="{{ asset('/img/ふきだしロゴ.png') }}" alt="コメント" class="item-detail__icon">
                </div>
                <p>{{ $item->comments->count() }}</p>
            </div>
        </div>

        <div class="item-detail__buy-action">
            <a href="{{ route('item.purchase', ['item_id' => $item->id]) }}" class="item-detail__buy-button">購入手続きへ</a>
        </div>

        <section class="item-detail__section">
            <h2 class="item-detail__section-title">商品説明</h2>
            <div class="item-detail__description">
                <p>{{ $item->description }}</p>
            </div>
        </section>

        <section class="item-detail__section">
            <h2 class="item-detail__section-title">商品の情報</h2>
            <div class="item-detail__info-table">
                <div class="item-detail__info-row">
                    <span class="item-detail__info-label">カテゴリー</span>
                    <div class="item-detail__category-tags">
                        @foreach($item->categories as $category)
                            <span class="item-detail__category-tag">{{ $category->content }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="item-detail__info-row">
                    <span class="item-detail__info-label">商品の状態</span>
                    <span class="item-detail__info-value">{{ $item->condition }}</span>
                </div>
            </div>
        </section>

        <section class="item-detail__comment-section">
            <h2 class="item-detail__section-title">コメント({{ $item->comments->count() }})</h2>
            
            <div class="item-detail__comment-list">
                @foreach($item->comments as $comment)
                    <div class="item-detail__comment-item">
                        <div class="item-detail__comment-user">
                            <div class="item-detail__user-icon">
                                @if($comment->user->image_url)
                                    <img src="{{ asset($comment->user->image_url) }}" alt="">
                                @endif
                            </div>
                            <span class="item-detail__user-name">{{ $comment->user->name }}</span>
                        </div>
                        <div class="item-detail__comment-bubble">
                            {{ $comment->content }}
                        </div>
                    </div>
                @endforeach
            </div>

            @auth
                <form action="{{ route('comment.store') }}" method="POST" class="item-detail__comment-form">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    
                    <div class="form__group">
                        <div class="form__group-title">
                            <span class="form__label--item">商品へのコメント</span>
                        </div>
                        <div class="form__group-content">
                            <div class="form__input--textarea">
                                <textarea name="content" required></textarea>
                            </div>
                            @error('content')
                                <p class="error-message" style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form__button">
                        <button type="submit" class="form__button-submit">コメントを送信する</button>
                    </div>
                </form>
            @else
                <p class="login-prompt">コメントするには<a href="{{ route('login') }}">ログイン</a>が必要です。</p>
            @endauth
        </section>
    </div>
</div>
@endsection