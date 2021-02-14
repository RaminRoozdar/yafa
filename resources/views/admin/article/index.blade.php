@extends('layouts.admin')
@section('css')

    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.css') }}">

@stop
@section('head_content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>مطالب</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="#">خانه</a></li>
                <li class="breadcrumb-item active">لیست مطالب</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">مطالب </h3>
                    <br>
                    <br>
                                        <a href="{{ route('admin.articles.create') }}" class="pull-left btn btn-danger btn-sm">ایجاد مطلب جدید</a>
                </div>


                <div class="card card-primary">

                    <table  class="table table-bordered table-hover data-table">
                        <thead>
                        <tr>
                            <th>شناسه</th>
                            <th>عنوان مطلب</th>
                            <th>گروه</th>
                            <th>نویسنده</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                    </table>


                </div>



            </div>
        </div>
    </div>



    <p class="text-center text-primary"><small>{{ config('platform.name') }}</small></p>

@endsection
@section('js')
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    {{--    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>--}}
    <script type="text/javascript">
        $(function () {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.articles.data') }}",
                columns: [
                    {data: 'id'},
                    {data: 'title'},
                    {data: 'category.category_name'},
                    {data: 'user.name'},
                    {data: 'action', orderable: false, searchable: false}
                ],
                oLanguage: {
                    "sEmptyTable": "هیچ داده ای در جدول وجود ندارد",
                    "sInfo": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
                    "sInfoEmpty": "نمایش 0 تا 0 از 0 رکورد",
                    "sInfoFiltered": "(فیلتر شده از _MAX_ رکورد)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLengthMenu": "نمایش _MENU_ رکورد",
                    "sLoadingRecords": "در حال بارگزاری...",
                    "sProcessing": "در حال پردازش...",
                    "sSearch": "جستجو:",
                    "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
                    "oPaginate": {
                        "sFirst": "ابتدا",
                        "sLast": "انتها",
                        "sNext": "بعدی",
                        "sPrevious": "قبلی"
                    },
                    "oAria": {
                        "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                        "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
                    }
                }

            });
        })
    </script>
@stop