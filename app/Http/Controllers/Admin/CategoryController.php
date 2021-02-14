<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = DB::table('categories')->orderBy('order' , 'asc')->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required',
        ]);
        $category = Category::create([
            'category_name' => $request['category_name'],
            'order' =>$request['order'],
        ]);
        $category->save();
        session()->flash('color', 'success');
        session()->flash('message', 'عملیات با موفقیت انجام گردید.');
        return redirect()->route('admin.categories.index');
    }

    public function edit($id)
    {

        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    public function update($id , Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required',
        ]);

        $category = Category::find($id);
        $category->category_name = $request->category_name;
        $category->order = $request->order;
        $category->save();
        session()->flash('color', 'success');
        session()->flash('message', 'گروه با موفقیت ویرایش گردید.');
        return redirect()->route('admin.categories.index');
    }
}
