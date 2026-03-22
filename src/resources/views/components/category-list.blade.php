<div class="form-group-category-grid">
    @foreach($categories as $category)
        <label class="form-label-category">
            <input 
                type="checkbox" 
                name="categories[]" 
                value="{{ $category->id }}" 
                class="form-input-checkbox"
                {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
            <span class="form-category-name">{{ $category->content }}</span>
        </label>
    @endforeach
</div>