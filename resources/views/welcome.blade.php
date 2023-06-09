@extends('common')

@section('content')
    @foreach($articles as $article)
        <div class="article-card">
            <div class="article-head">
                <h2 class="article-title"><a href="anomalies/{{$article->id}}">{{$article->title}}</a></h2>
{{--                <span class="article-publishing-date">{{$article->publishedAt}}</span>--}}
{{--                <div class="logo-component">--}}
{{--                    <img class="eye" src="{{asset('icons/eye.svg')}}" alt="eye">--}}
{{--                    <div class="views-count">--}}
{{--                        <span>{{$article->viewCount}}</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
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
