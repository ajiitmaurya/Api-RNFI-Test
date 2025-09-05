<?php

namespace App\Http\Controllers;

use App\Helpers\EncryptHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class ArticleController extends Controller
{

    public function index(Request $request)
    {
        $key = $request->bearerToken();
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)->get()->toArray();
        return response()->json(EncryptHelper::encrypt($articles, $key));
    }

    public function show(Request $request, $id)
    {
        $key = $request->bearerToken();
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }
        return response()->json(EncryptHelper::encrypt($article, $key));
    }

    // Create new article
    public function store(Request $request)
    {

        $key = $request->bearerToken();
        $data = EncryptHelper::decrypt($request->getContent(), $key);
        $user = Auth::user();
        $data['user_id'] = $user->id;

        $article = Article::create($data);
        return response()->json(EncryptHelper::encrypt($article, $key), 201);
    }

    // Update article
    public function update(Request $request, $id)
    {
        $key = $request->bearerToken();
        $data = EncryptHelper::decrypt($request->getContent(), $key);
        $article = Article::find($id);
        $article->update(['title' => $data['title'], 'content' => $data['content']]);
        return response()->json(EncryptHelper::encrypt($article, $key));
    }

    // Delete article
    public function destroy($id)
    {
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }
        $article->delete();
        return response()->json(['message' => 'Article deleted']);
    }
}
