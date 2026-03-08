<!-- カテゴリーの選択肢を配列で定義（後でDB化も可能） -- resources/views/components/category-list.blade.php -->
<div class="category-grid">
    @foreach($categories as $category)
        <label class="category-label">
            <!-- シーダーで入れた id を値にし、content をラベルにします -->
            <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
            <span class="category-name">{{ $category->content }}</span>
        </label>
    @endforeach
</div>