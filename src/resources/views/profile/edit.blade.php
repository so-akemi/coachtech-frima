@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
    <div class="profile-edit-content">
        <div class="profile-edit-heading">
            <h1>プロフィール設定</h1>
        </div>
        
        <form class="form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <div class="form-user-avatar">
                    <div class="form-avatar-circle">
                        @if($user->image_url)
                            <img src="{{ asset('storage/' . $user->image_url) }}" alt="" class="form-avatar-img">
                        @endif
                    </div>

                    <div class="form-avatar-input">
                        <label class="form-label-file">
                            画像を選択する
                            <input type="file" name="image" accept="image/*">
                        </label>
                    </div>
                </div>
                
                <div class="form-group-title">
                    <span class="form-label-item">ユーザー名</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="user_name" value="{{ old('user_name', $user->name) }}">
                    </div>
                    <div class="form-error">
                        @error('user_name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">郵便番号</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
                    </div>
                    <div class="form-error">
                        @error('postal_code')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">住所</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="address" value="{{ old('address', $user->address) }}">
                    </div>
                    <div class="form-error">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">建物名</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="building" value="{{ old('building', $user->building) }}">
                    </div>
                </div>
            </div>

            <div class="form-button">
                <button type="submit" class="form-button-submit">更新する</button>
            </div>
        </form>
    </div>
@endsection