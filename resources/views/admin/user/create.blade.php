@extends('layouts.admin')
@section('css')


@stop
@section('head_content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>ثبت کاربر جدید</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="#">خانه</a></li>
                <li class="breadcrumb-item">کاربران</li>
                <li class="breadcrumb-item active">ثبت کاربر جدید</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ثبت کاربر</h3>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">ثبت کاربر جدید</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('admin.users.create')}}" method="POST" >
                        @CSRF
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">نام و نام خانوادگی</label>
                                <input type="text" class="form-control" name="name" placeholder="نام و نام خانوادگی را وارد کنید" value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">شماره موبایل</label>
                                <input type="text" class="form-control" name="mobile" dir="ltr"  placeholder="0917*******" value="{{old('mobile')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">رمز عبور</label>
                                <input type="password" class="form-control" name="password"  placeholder="پسورد را وارد کنید">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">نقش کاربر</label>
                                <select class="form-control" name="role" id="role">
                                    <option>نقش کاربر را انتخاب کنید</option>
                                    @foreach($roles as $role)
                                        @if(isset($userRole[0]))
                                            <option value="{{ $role}}"{{old('role' , $userRole[0]) == $role ? ' selected' : ''}}>{{ __('permission.attributes.'.$role) }}</option>
                                        @else

                                            <option value="{{ $role}}"{{old('role')}}>{{ __('permission.attributes.'.$role) }}</option>
                                        @endif
                                    @endforeach
                                </select>
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



    <p class="text-center text-primary"><small>تشک سازی مرودشت</small></p>
@endsection
@section('js')

@stop