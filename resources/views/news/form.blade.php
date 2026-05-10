<!-- Title -->
<div class="mb-3">
    <label>Заголовок</label>
    <input type="text" name="title" class="form-control"  value="{{ old('title', $news->title ?? '') }}">
    @error('title')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Body -->
<div class="mb-3">
    <label>Текст</label>
    <textarea name="body" id="editor" class="form-control">{{ old('body', $news->body ?? '') }}</textarea>
    @error('body')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Image -->
<div class="mb-3">
    <label>Картинка</label>
    @if(!empty($news?->image))
        <div class="mb-2">
            <img src="{{ asset('storage/'.$news->image) }}" width="200">
        </div>
    @endif

    <input type="file" name="image" class="form-control">
</div>

<!-- Published -->
<div class="form-check mb-3">
    <input
        type="checkbox"
        name="published"
        value="1"
        class="form-check-input"
        {{ old('published', $news->published ?? false) ? 'checked' : '' }}
    >
    <label class="form-check-label">Опубликовать</label>
</div>

