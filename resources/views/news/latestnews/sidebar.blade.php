<div class="latest-news-sidebar">
    <h3>Последние новости</h3>

    @foreach($latestNews as $news)
        @include('news.latestnews.new', ['news' => $news])
    @endforeach
    <hr>
    link 2 news
    <hr>
</div>
