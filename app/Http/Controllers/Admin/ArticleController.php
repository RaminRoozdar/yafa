<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    public function index()
    {
        return view('admin.article.index');
    }
    public function data()
    {
        return DataTables::eloquent(Article::with('category','user')->orderBy('created_at','desc')->select(['*']))
            ->addColumn('action', 'admin.article.action')
            ->make(true);
    }

    public function create()
    {
        $allTags= Tag::get();
        $categories = DB::table('categories')->select('id' , 'category_name')->get();
        return view('admin.article.create',compact('categories' , 'allTags'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'text' => 'required|string',
            'category_id' => 'required',
            'image' => 'max:3000|required|mimes:jpeg,jpg,png,gif',
        ]);
        $article = new Article();
        $article->title = $request->title;
        $article->text = $request->text;
        $article->slug = $request->slug;
        $article->category_id = $request->category_id;
        $article->user_id = Auth::user()->id;
        if ($request->hasFile('image'))
        {
            $fileName = $request->file('image')->store('public/article');
            Image::make(storage_path('app/'.$fileName) )->resize(800, 400)->save(storage_path('app/'.$fileName));
        }
        $article->image = $fileName;
        $article->save();
        if ($article && $article instanceof Article)
        {
            $tags = $request->input('postTags');
            foreach ($tags as $key=>$tag){
                if (intval($tag) == 0 ){
                    unset($tags[$key]);
                    $newTag = Tag::create(['name' => $tag]);
                    $tags[] = $newTag->id;
                }
            }
            $tags = array_map(function ($item){
                return intval($item);
            },$tags);
            $tags = array_unique($tags);
            $article->tags()->sync($tags);
        }
        session()->flash('message', 'مطلب جدید با موفقیت ایجاد گردید');
        session()->flash('color', 'success');
        return redirect()->route('admin.articles.index');
    }

    public function edit ($id)
    {
        $categories = Category::get();
        $article = Article::findOrFail($id);
        $allTags = Tag::get();
        $postTags = $article->tags->pluck('id')->toArray();
        return view('admin.article.edit',compact('article','categories','allTags','postTags'));
    }
    public function update($id , Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'text' => 'required|string',
            'category_id' => 'required',
            'image' => 'nullable|max:3000|mimes:jpeg,jpg,png,gif',
        ]);

        $article = Article::find($id);
        $article->title = $request->title;
        $article->text = $request->text;
        $article->slug = $request->slug;
        $article->category_id = $request->category_id;
        $article->user_id = Auth::user()->id;
        if ($request->hasFile('image'))
        {
            Storage::delete($article->image);
            $fileName = $request->file('image')->store('public/article');
            Image::make(storage_path('app/'.$fileName) )->resize(800, 400)->save(storage_path('app/'.$fileName));
            $article->image = $fileName;
        }
        $article->save();
        $tags = $request->input('postTags');
        foreach ($tags as $key=>$tag){
            if (intval($tag) == 0 ){
                unset($tags[$key]);
                $newTag = Tag::create(['name' => $tag]);
                $tags[] = $newTag->id;
            }
        }
        $tags = array_map(function ($item){
            return intval($item);
        },$tags);
        $tags = array_unique($tags);
        $article->tags()->sync($tags);
        session()->flash('color', 'success');
        session()->flash('message', 'مطلب با موفقیت ویرایش گردید.');
        return redirect()->route('admin.articles.index');
    }


}
