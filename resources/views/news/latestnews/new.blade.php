<div class="latest-news-item">
<div class="latest-new-title">{{ $news->title }}</div>
    <div class="latest-new-image"><img src="{{ image_style($news->image, 'small') }}"></div>
<div class="latest-new-body">
    {{ $news->excerpt }}
</div>
<div class="latest-new-date-author">
<div class="latest-new-date">{{ $news->created_at->format('Y/m/d H:i') }}</div>
<div class="latest-new-author">{{ $news->user->name }}</div>
</div>
<div class="latest-new-more">
    <a href="{{ route('news.show', $news->slug) }}" title="Подробнее...">
        Подробнее...
    </a>
</div>
</div>
