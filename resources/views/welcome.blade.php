@extends('common')

@section('content')
    @foreach($articles as $article)
        <div class="article-card">
            <div class="article-head">
                <h2 class="article-title">{{$article->title}}</h2>
                <span class="article-publishing-date">{{$article->publishedAt}}</span>
                <span class="article-rating article-rating-{{$article->ratingColor}}">{{$article->rating === null ? '-/-' : round($article->rating, 1)}}</span>
            </div>
            <p class="article-content">{{$article->content}}</p>
            <div class="tags">
                @foreach($article->tags as $tag)
                    <span class="tag">#{{$tag->title}}</span>
                @endforeach
            </div>
            <form method="POST" action="/api/articles">
                @method('DELETE')
                @csrf
                <div>
                    <label for="id"></label>
                    <input id="id" name="id" value="{{$article->id}}" hidden="hidden"/>
                </div>
                <button type="submit" class="common-button">Remove</button>
            </form>
            <a href="articles/edit/{{$article->id}}">Edit</a>
        </div>
    @endforeach
@endsection

@section('article-action')
    <div class="create-article-component">
        <div class="create-article-component-link">
            <a href="/articles/create">Create article</a>
        </div>
    </div>
@endsection

<script>
    document.querySelector('')
</script>
