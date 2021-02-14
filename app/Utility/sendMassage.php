<?php
/**
 * Created by PhpStorm.
 * User: ramin
 * Date: 1/4/2020
 * Time: 4:14 PM
 */

namespace App\Utility;


use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class sendMassage
{

    public static function verify($mobile , $code)
    {
        $text = view()->make('partials.orderPaySms', ['code'=>$code])->render();
        $client = new Client();
        $response = $client->request('POST', 'https://api.sabanovin.com/v1/sa1820580606:R7wiVDTMVblS17WnjaGck6fqFn5dOUnG2TYX/sms/send.json', [
            'form_params' => [
                'gateway' => '20007132922',
                'to' => $mobile,
                'text' => $text,
            ]
        ]);
    }

}