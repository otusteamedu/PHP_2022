@extends('layouts.app')
@section('content')
    <?php /** @var \App\Models\Article $article */ ?>
    <div class="container">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">
                    {{ $article->title }} ({{ $articleViews }})
                </h1>
                <p class="lead">
                    <div>
                        @foreach ($article->tags as $tag)
                            <span class="badge badge-light">{{ $tag}}</span>
                        @endforeach
                    </div>
                </p>
            </div>
        </div>
        <p class="text-justify">{{ $article->body }}</p>
    </div>
@stop
