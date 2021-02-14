@extends('layouts.admin')

@section('title')
    جزئیات نقش   {{ __('permission.attributes.'.$role->name) }}
    @endsection
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
                <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">نقش ها</a></li>
                <li class="breadcrumb-item active">جزئیات نقش   {{ __('permission.attributes.'.$role->name) }}</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"> دسترسی های نقش   {{ __('permission.attributes.'.$role->name) }} </h3>
                </div>
                <div class="card-body">
                    <!-- Minimal style -->

                    <!-- checkbox -->
                    <div class="form-group">
                        @if(!empty($rolePermissions))
                            @foreach($rolePermissions as $v)
                              <div class="form-group">
                                  <label>
                                      {{ __('permission.attributes.'.$v->name) }}
                                  </label>
                              </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    ویرایش دسترسی های نقش<a href="{{route('admin.roles.edit',['id'=>$role->id])}}">  {{ __('permission.attributes.'.$role->name) }}   </a>
                </div>
            </div>
        </div>
    </div>



    <p class="text-center text-primary"><small>{{ config('platform.name') }}</small></p>

@endsection
@section('js')

@stop