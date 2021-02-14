<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        if (Session::token() != Input::get('_token')) {
            throw new Illuminate\Session\TokenMismatchException;
        }
        $funcNum = Input::get('CKEditorFuncNum');
        $message = $url = '';
        if (Input::hasFile('upload')) {
            $file = Input::file('upload');
            if ($file->isValid()) {
                $image = new Image();
                $image->source = $request->file('upload')->store('public/ckEditor');
                $image->size = $request->file('upload')->getSize();
                $image->user_id = Auth::user()->id;
                $image->save();
                $url = Storage::url($image->source);
            } else {
                $message = 'خطای در زمان لود تصویر رخ داد.';
            }
        } else {
            $message = 'فایل بارگزاری نشد.';
        }
        return '<script>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'", "'.$message.'")</script>';
    }
}
