<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.contact.index');
    }

    public function data()
    {
        return DataTables::eloquent(Contact::orderBy('created_at','desc')->select(['*']))
            ->addColumn('action', 'admin.contact.action')
            ->make(true);
}
}
