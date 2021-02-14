<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contactInsert(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string',
            'mobile' => 'required',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
        $message = new Contact();
        $message->name = $request->name;
        $message->email = $request->email;
        $message->mobile = $request->mobile;
        $message->subject = $request->subject;
        $message->message = $request->message;
        $message->save();

        session()->flash('color', 'success');
        session()->flash('message', 'پیام با موفقیت ارسال شد.');
        return redirect()->back();
    }
}
