@extends('layouts.admin')
@section('head_content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>تنظیمات</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="#">خانه</a></li>
                <li class="breadcrumb-item active">تنطیمات</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تنظیمات</h3>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">تنظیمات عمومی</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                        <form class="form" action="{{ route('admin.settings.update') }}" method="POST">
                        @CSRF
                        <div class="card-body">
                            <input type="hidden" name="_method" value="PUT">
                                    @foreach($settings as $setting)
                                        <div class="form-group">
                                                    <label for="{{$setting->key}}">{{settingMapper($setting->key)}}</label>
                                            <div class="col-md-7">
                                                    <input type="text" id="{{$setting->key}}" name="{{$setting->key}}" value="{{$setting->value}}" class="form-control pnmbr edited" />

                                                </div>


                                        </div>
                                    @endforeach

                        </div>

                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">ذخیره</button>
                            </div>
                    </form>
                        </div>


                </div>


            </div>
        </div>

@stop