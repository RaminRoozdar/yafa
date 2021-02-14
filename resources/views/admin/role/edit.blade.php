@extends('layouts.admin')

@section('title')
    ویرایش دسترسی های نقش   {{ __('permission.attributes.'.$role->name) }}
@endsection
@section('css')


@stop
@section('head_content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1> نقش   {{ __('permission.attributes.'.$role->name) }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="#">خانه</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">نقش ها</a></li>
                <li class="breadcrumb-item active">ویرایش نقش   {{ __('permission.attributes.'.$role->name) }}</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"> ویرایش دسترسی های نقش   {{ __('permission.attributes.'.$role->name) }} </h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('admin.roles.update',['id'=> $role->id]) }}" method="POST" novalidate="novalidate">
                        {!! csrf_field() !!}
                        <div class="row justify-content-center">
                            <div class="col-md-10">


                                <div class="form-group row">
                                    <label for="role" class="col-md-4 col-form-label">نقش کاربر</label>

                                    <div class="col-md-7">
                                        <ul>
                                            @foreach($permission as $value)
                                                <li  class="col-md-4" style="list-style: none; display: inline-block">
                                                    <input type="checkbox" name="permission[]" value="{{ old('id',$value->id) }}"
                                                            {{in_array($value->id, $rolePermissions) ? 'checked' : ''}}
                                                    >
                                                    {{--{{ $value->name }}--}}
                                                    {{ __('permission.attributes.'.$value->name) }}
                                                </li>
                                            @endforeach
                                        </ul>


                                    </div>
                                </div>

                                <div class="col-md-12 mb-1">
                                    <button type="submit" class="btn btn-block btn-danger btn-sm">
                                        <i class="fa fa-save"></i>
                                        ثبت تغییرات
                                    </button>
                                </div>

                            </div>
                        </div>

                    </form>


                </div>
                <div class="card-footer">
                    برگشت به<a href="{{ route('admin.roles.index') }}">  مدیریت نقش ها </a>
                </div>
            </div>
        </div>
    </div>



    <p class="text-center text-primary"><small>{{ config('platform.name') }}</small></p>

@endsection
@section('js')

@stop