<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = DB::table('sliders')->orderBy('id' , 'desc')->paginate(10);
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'link' => 'nullable|string',
            'image' => 'max:3000|required|mimes:jpeg,jpg,png,gif',
        ]);
        $slider = new Slider();
        $slider->title = $request->title;
        $slider->link = $request->link;
        if ($request->hasFile('image'))
        {
            $fileName = $request->file('image')->store('public/slider');
            Image::make(storage_path('app/'.$fileName) )->resize(800, 400)->save(storage_path('app/'.$fileName));
        }
        $slider->image = $fileName;
        $slider->save();
        session()->flash('message', 'اسلایدر جدید با موفقیت ایجاد گردید');
        session()->flash('color', 'success');
        return redirect()->route('admin.sliders.index');
    }

    public function edit ($id)
    {
        $slider = Slider::find($id);
        return view('admin.slider.edit',compact('slider'));
    }
    public function update($id , Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'link' => 'nullable|string',
            'image' => 'nullable|max:3000|mimes:jpeg,jpg,png,gif',
        ]);

        $slider = Slider::find($id);
        $slider->title = $request->title;
        $slider->link = $request->link;
        if ($request->hasFile('image'))
        {
            Storage::delete($slider->image);
            $fileName = $request->file('image')->store('public/slider');
            Image::make(storage_path('app/'.$fileName) )->resize(800, 400)->save(storage_path('app/'.$fileName));
            $slider->image = $fileName;
        }

        $slider->save();
        session()->flash('color', 'success');
        session()->flash('message', 'اسلایدر با موفقیت ویرایش گردید.');
        return redirect()->route('admin.sliders.index');
    }
}
