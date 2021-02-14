<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = DB::table('settings')->get();
        return view('admin.setting.edit', compact('settings'));
    }
    public function update(Request $request)
    {

        $keys = DB::table('settings')->get()->pluck('key')->toArray();
        foreach ($request->all() as $key=>$value) {
            if(!in_array($key, $keys)) continue;
            $value = toEngNumber(trim($value));
            if(settings()->get($key) === $value) continue;
            settings()->set($key, $value);
        }
        session()->flash('message', 'تغییرات انجام شد.');
        session()->flash('color', 'success');
        return redirect()->back();
    }
}
