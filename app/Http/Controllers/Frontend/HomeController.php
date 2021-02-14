<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $articles = Article::with('category')->limit(5)->orderBy('created_at', 'desc')->get();
        $categorise = Category::get();
        return view('welcome',compact('sliders' , 'articles' , 'categorise'));
    }
}
