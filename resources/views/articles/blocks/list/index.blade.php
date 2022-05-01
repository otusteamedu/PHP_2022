@forelse ($articles as $article)
    @include('articles.blocks.list.item')
@empty
    <p>No articles found</p>
@endforelse
