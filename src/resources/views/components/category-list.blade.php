<div class="form__group-category-grid">
    @foreach($categories as $category)
        <label class="form__label--category">
            <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="form__input--checkbox"
                {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
            <span class="form__category-name">{{ $category->content }}</span>
        </label>
    @endforeach
</div>