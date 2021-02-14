@extends('layouts.admin')
@section('title')
    ویرایش گروه {{ $category->category_name }}
@stop
@section('css')


@stop
@section('head_content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>ویرایش گروه {{ $category->category_name }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">خانه</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}"></a></li>
                <li class="breadcrumb-item active">ویرایش گروه {{ $category->category_name }}</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش گروه</h3>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">ویرایش</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('admin.categories.update',['id'=> $category->id])}}" method="POST" >
                        @CSRF
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">عنوان گروه</label>
                                <input type="text" class="form-control" name="category_name" placeholder="عنوان گروه را وارد کنید" value="{{old('category_name',$category->category_name)}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">ترتیب</label>
                                <input type="number" class="form-control" name="order" dir="ltr"  placeholder="1" value="{{old('order',$category->order)}}">
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