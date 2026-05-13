<div class="latest-news-sidebar">
    <h3>Последние новости</h3>

    @foreach($latestNews as $news)
        @include('news.latestnews.new', ['news' => $news])
    @endforeach
<div class="all-news">
    <a href="{{ route('news.index') }}">Все новости >>></a>
</div>
</div>
