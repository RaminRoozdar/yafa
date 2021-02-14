@extends('layouts.admin')
@section('title')
    ویرایش اسلایدر {{ $slider->title }}
@stop
@section('css')


@stop
@section('head_content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>ویرایش گروه {{ $slider->title }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">خانه</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.sliders.index')}}"></a></li>
                <li class="breadcrumb-item active">ویرایش گروه {{ $slider->title }}</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش اسلاید</h3>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">ویرایش</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('admin.sliders.update',['id'=> $slider->id])}}" method="POST" enctype="multipart/form-data">
                        @CSRF
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">عنوان اسلاید</label>
                                <input type="text" class="form-control" name="title" placeholder="عنوان اسلاید را وارد کنید" value="{{old('title',$slider->title)}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">لینک</label>
                                <input type="url" class="form-control" name="link" dir="ltr"  placeholder="http://sabanovin.com" value="{{old('link',$slider->link)}}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">تصویر اسلایدر</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                                        <label class="custom-file-label" for="exampleInputFile">انتخاب تصویر</label>
                                    </div>
                                </div>
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

@stop