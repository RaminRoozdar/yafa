@extends('layouts.admin')
@section('title')
    ویرایش مطلب {{ $article->title }}
@stop
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>


@stop
@section('head_content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>ویرایش مطلب {{ $article->title }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">خانه</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.articles.index')}}">مطالب</a></li>
                <li class="breadcrumb-item active">ویرایش مطلب {{ $article->title }}</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش مطلب</h3>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">ویرایش</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('admin.articles.update',['id'=> $article->id])}}" method="POST" enctype="multipart/form-data">
                        @CSRF
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">عنوان مطلب</label>
                                <input type="text" class="form-control" name="title" placeholder="عنوان مطلب را وارد کنید" value="{{old('title',$article->title)}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">عنوان لاتین</label>
                                <input type="text" class="form-control" name="slug" placeholder="عنوان لاتین" value="{{old('slug',$article->slug)}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">گروه مطلب</label>
                                <select class="form-control" name="category_id" id="category_id" >
                                    <option >گروه را انتخاب کنید ...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"{{ old('category_id', $article->category_id) == $category->id  ? ' selected' : '' }}>{{$category->category_name}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">تصویر مطلب</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                                        <label class="custom-file-label" for="exampleInputFile">انتخاب تصویر</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">محتوای مطلب</label>
                                <textarea class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" name="text" id="text" required>{{ old('text',$article->text) }}</textarea>

                                @if ($errors->has('text'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">برچسب های مطلب</label>
                                <select class="form-control" multiple name="postTags[]" id="postTags" required>
                                    @foreach($allTags as $tag)
                                        <option value="{{ $tag->id }}"
                                                {{ in_array($tag->id , $postTags)?'selected':''}}
                                        >{{ $tag->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">ذخیره</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>



    <p class="text-center text-primary"><small>{{ config('platform.name') }}</small></p>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        jQuery(document).ready(function ($) {

            $('#postTags').select2({
                tags:true,
                theme:"classic",
                minimumInputLength:3,
                dir: "rtl",
                language: "fa",
            });
            $('#category_id').select2({
                dir: "rtl",
                language: "fa",
            });

        });
    </script>
    @include('global.ckeditor',['editors' => ['text']])
@stop