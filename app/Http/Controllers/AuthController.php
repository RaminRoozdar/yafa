<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginPhone()
    {
        return view('auth.login');
    }
    public function doLoginPhone(Request $request)
    {

        $data = $request->all();
        $mobile =   $request['mobile'] = preg_replace('~^[0\D]++|\D++~', '', $request['mobile']);
        $this->validate($request, [
            'mobile' => 'required|exists:users',
        ]);
        $user = User::where('mobile', $mobile)->first();

        $token = Token::create([
            'user_id' => $user->id
        ]);

        $rememberMe = (!empty($request->remember_me)) ? TRUE : FALSE;
        if ($token->sendCode()) {
            session()->put("code_id", $token->id);
            session()->put("user_id", $user->id);
            session()->put("remember", $rememberMe);

            return redirect()->route('verify');
        }

        $token->delete();
        session()->flash('color', 'error');
        session()->flash('message', 'کد تأیید ارسال نشد.');
        return redirect()->route('loginPhone');

    }
    public function verify() {
        return view('auth.verify');
    }

    public function doVerify(Request $request) {
        $this->validate($request, [
            'code' => 'required|numeric'
        ]);

        if (!session()->has('code_id') || !session()->has('user_id'))
            redirect()->route('loginPhone');

        $token = Token::where('user_id', session()->get('user_id'))->find(session()->get('code_id'));

    if (!$token || empty($token->id))
        redirect()->route('loginPhone');

    if (!$token->isValid())
        session()->flash('color', 'error');
        session()->flash('message', 'کد منقضی شده یا استفاده شده است.');
        redirect()->back();

    if ($token->code !== $request->input('code'))
        session()->flash('color', 'error');
        session()->flash('message', 'کد اشتباه است.');
        redirect()->back();

    $token->update([
        'used' => true
    ]);

    $user = User::find(session()->get('user_id'));

    $rememberMe = session()->get('remember');

    auth()->login($user, $rememberMe);

    return redirect()->route('dashboard');
}
    public function logout()
    {
        auth()->logout();
        return redirect()->back();
    }
}
