@extends('common')

@section('content')
    <form class="create-articles-form" method="POST" action="/api/articles">
        @method('PUT')
        @csrf
        <div>
            <label for="id"></label>
            <input id="id" name="id" value="{{$article->id}}" hidden="hidden">
        </div>
        <div class="create-article-field">
            <label for="title">Title: </label>
            <input id="title" name="title" value="{{$article->title}}">
        </div>
        <div class="create-article-field">
            <label for="content"></label>
            <textarea class="create-article-content-textarea" id="content" name="content">{{$article->content}}</textarea>
        </div>
        <button type="submit" class="common-button">Edit</button>
    </form>
@endsection

@section('article-action')
    <div class="create-article-component">
        <div class="create-article-component-link">
            <a href="/">Back</a>
        </div>
    </div>
@endsection
