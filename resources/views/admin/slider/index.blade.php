@extends('layouts.admin')
@section('css')


@stop
@section('head_content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>اسلایدر ها</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="#">خانه</a></li>
                <li class="breadcrumb-item active">لیست اسلایدر ها</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">اسلایدر ها </h3>
                    <br>
                    <br>
                                        <a href="{{ route('admin.sliders.create') }}" class="pull-left btn btn-danger btn-sm">ایجاد اسلایدر جدید</a>
                </div>


                <div class="card card-primary">

                    <!-- /.card-header -->
                    <table class="table table-bordered">
                        <tbody><tr>
                            <th>شناسه</th>
                            <th>عنوان اسلایدر</th>
                            <th>لینک اسلایدر</th>
                            <th>تصویر اسلایدر</th>
                            <th>عملیات</th>
                        </tr>

                            @foreach ($sliders as $slider)
                                <tr>
                                    <td>{{ $slider->id }}</td>
                                    <td> {{ $slider->title }} </td>
                                    <td><a target="_blank" href="{{ $slider->link }}">{{ $slider->link }}</a> </td>
                                    <td ><img width="100px" height="100px" src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}"> </td>
                                    <td>
                                        {{--@can('role-edit')--}}
                                        <a class="btn btn-primary" href="{{ route('admin.sliders.edit',$slider->id) }}">ویرایش</a>
                                        {{--@endcan--}}
                                        {{--@can('role-delete')--}}
                                        {{--<a class="btn btn-danger" href="#">حذف</a>--}}
                                        {{--@endcan--}}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {!! $sliders->render() !!}
                </div>



            </div>
        </div>
    </div>



    <p class="text-center text-primary"><small>{{ config('platform.name') }}</small></p>

@endsection
@section('js')

@stop