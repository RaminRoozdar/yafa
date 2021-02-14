@extends('layouts.admin')
@section('css')


@stop
@section('head_content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>نقش ها</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="#">خانه</a></li>
                <li class="breadcrumb-item active">لیست نقش ها</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">نقش ها و دسترسی ها </h3>
                    <br>
                    <br>
{{--                    <a href="{{ route('admin.roles.create') }}" class="pull-left btn btn-danger btn-sm">ایجاد نقش جدید</a>--}}
                </div>

                <div class="card card-primary">

                    <!-- /.card-header -->
                    <table class="table table-bordered">
                        <tbody><tr>
                            <th>ترتیب</th>
                            <th>نام</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td> {{ __('permission.attributes.'.$role->name) }} </td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('admin.roles.show',['id'=>$role->id]) }}">جزئیات</a>
                                    {{--@can('role-edit')--}}
                                    <a class="btn btn-primary" href="{{ route('admin.roles.edit',['id'=>$role->id]) }}">ویرایش</a>
                                    {{--@endcan--}}
                                    {{--@can('role-delete')--}}
                                        {{--<a class="btn btn-danger" href="#">حذف</a>--}}
                                    {{--@endcan--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>



    <p class="text-center text-primary"><small>{{ config('platform.name') }}</small></p>

@endsection
@section('js')

@stop