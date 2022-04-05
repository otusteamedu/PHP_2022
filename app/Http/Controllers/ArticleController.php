<?php

namespace App\Http\Controllers;

use App\Services\Articles\ArticleService;
use Illuminate\Http\Request;
use View;

class ArticleController extends Controller
{

    private ArticleService $articleService;

    public function __construct(
        ArticleService $articleService
    )
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        $limit = 200;
        $search = $request->get('q', '');
        $offset = $request->get('page', 0) * $limit;

        $articles = $this->articleService->search(
            $search,
            $limit,
            $offset
        );

        View::share([
            'articles' => $articles,
            'search' => $search,
        ]);
        return view('articles.index');
    }

    public function show(Request $request, int $id)
    {
        $article = $this->articleService->showArticle(
            $id,
            $request->ip(),
        );

        View::share([
            'article' => $article,
            'articleViews' => $article->views,
        ]);
        return view('articles.show');
    }

}
