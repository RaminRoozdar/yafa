<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }
    public function data()
    {
        return DataTables::eloquent(User::select('users.*' , 'users.id as aid')->orderBy('users.id', 'desc'))
            ->editColumn('id', function($data) {
                if(isset($data->getRoleNames()[0]))
                    return __('permission.attributes.'.$data->getRoleNames()[0]) ;
                return 'کاربر عادی';
            })
            ->addColumn('action', 'admin.user.action')
            ->make(true);
    }
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.user.create',compact('roles'));
    }
    public function store(Request $request)
    {
      $mobile =   $request['mobile'] = preg_replace('~^[0\D]++|\D++~', '', $request['mobile']);
        $this->validate($request, [
            'name' => 'required',
            'mobile'     => 'required|unique:users|digits:10',
            'password' => 'required',
            'role' => 'required'
        ]);
        $user = User::create([
            'name' => $request['name'],
            'mobile' =>$mobile,
            'password' => bcrypt($request['password']),
        ]);
        $user->save();
        $user->assignRole($request->input('role'));
        session()->flash('color', 'success');
        session()->flash('message', 'عملیات با موفقیت انجام گردید.');
        return redirect()->route('admin.users.index');
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name')->all();
        $userRole = $user->roles->pluck('name');
        return view('admin.user.edit',compact('user','roles','userRole'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
//            'mobile' => 'required|digits:10|mobile|unique:users,'.$id,
            'role' => 'required'
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->save();
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('role'));
        session()->flash('color', 'success');
        session()->flash('message', 'عملیات با موفقیت انجام گردید.');
        return redirect()->route('admin.users.index');
    }
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('admin.users.index')
            ->with('success','User deleted successfully');
    }
}
