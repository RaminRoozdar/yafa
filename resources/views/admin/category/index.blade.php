@extends('layouts.admin')
@section('css')


@stop
@section('head_content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>گروه ها</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="#">خانه</a></li>
                <li class="breadcrumb-item active">لیست گروه ها</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">گروه بندی ها </h3>
                    <br>
                    <br>
                                        <a href="{{ route('admin.categories.create') }}" class="pull-left btn btn-danger btn-sm">ایجاد گروه جدید</a>
                </div>


                <div class="card card-primary">

                    <!-- /.card-header -->
                    <table class="table table-bordered">
                        <tbody><tr>
                            <th>شناسه</th>
                            <th>نام</th>
                            <th>ترتیب</th>
                            <th>عملیات</th>
                        </tr>

                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td> {{ $category->category_name }} </td>
                                    <td> {{ $category->order }} </td>
                                    <td>
                                        <a class="btn btn-info" href="#">جزئیات</a>
                                        {{--@can('role-edit')--}}
                                        <a class="btn btn-primary" href="{{ route('admin.categories.edit',$category->id) }}">ویرایش</a>
                                        {{--@endcan--}}
                                        {{--@can('role-delete')--}}
                                        {{--<a class="btn btn-danger" href="#">حذف</a>--}}
                                        {{--@endcan--}}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {!! $categories->render() !!}
                </div>



            </div>
        </div>
    </div>



    <p class="text-center text-primary"><small>{{ config('platform.name') }}</small></p>

@endsection
@section('js')

@stop