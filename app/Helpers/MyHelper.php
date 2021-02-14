<?php

namespace App\Helpers;

use App\Delivery;
use App\Enums\DeliveryEnum;
use App\Enums\SentMessageEnum;
use App\Enums\TransactionEnum;
use App\Line;
use App\SentMessage;
use App\User;
use Carbon\Carbon;
use Cache;
use DB;
use Redis;
use GuzzleHttp;
use App\Jobs\CreateAndSendSmsJob;
use App\Jobs\SendSmsJob;
use Cron\CronExpression;
use Zipper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\TempBlackList;
use App\Jobs\ReturnMoneyBackJob;
use App\WebserviceLog;
use App\WebhookLog;
use App\Tag;


class MyHelper {

    public static function getTariffs($level_id, $lang, $sms_operator_id)
    {

        $prices = [
            'mtn' => 0,
            'mci' => 0,
            'rightel' => 0,
            'talia' => 0,
            'spadan' => 0,
            'tkc' => 0,
        ];
        foreach($prices as $key=>$price) {
            $prices[$key] = Cache::remember("tariff-$level_id-$lang-$key-$sms_operator_id", 60*24, function() use ($level_id, $sms_operator_id, $lang, $key) {
                $price = DB::table('tariffs')
                    ->selectRaw('tariffs.price_'.$lang)
                    ->join('mobile_operators', 'tariffs.mobile_operator_id', 'mobile_operators.id')
                    ->where('tariffs.level_id', $level_id)
                    ->where('tariffs.sms_operator_id', $sms_operator_id)
                    ->where('mobile_operators.name', $key)
                    ->first()->{'price_'.$lang};
                return $price;
            });
        }
        return [
            'mtn'=>$prices['mtn'],
            'mci'=>$prices['mci'],
            'rightel'=>$prices['rightel'],
            'talia'=>$prices['talia'],
            'spadan'=>$prices['spadan'],
            'tkc'=>$prices['tkc'],
            'unknown'=> '0'
        ];
    }

    public static function changeArrayToParenthesisString(array $array, $slashes = false)
    {
        $str = '(';
        foreach ($array as $key=>$value) {
            $str .= $slashes ? "'$value'" : $value;
            $key < count($array) -1 ? $str .= ',' : '';
        }
        $str .= ')';
        return $str;
    }

    public static function removeMobilePrefix($numbers)
    {
        return preg_replace('/^(\+98| 98|0098|98|00|0)/', '', $numbers);
    }

    public static function getRealMobileNumbers($numbers)
    {
        $new = [];
        foreach($numbers as $key=>$number) {
            $n = getRealMobileNumber($number);
            if( ! $n )
                continue;
            $new[$key] = $n;
        }
        return $new;
    }

    public static function getPriceOfThisNumber($level_id = null, $number, $lang, $sms_operator_id)
    {
        $tariffs = self::getTariffs($level_id, $lang, $sms_operator_id);
        return $tariffs[getMobileOperator($number)];
    }

    public static function getPriceOfNumbers($level_id = null, $numbers, $messageInfo, $sms_operator_id)
    {
        $tariffs = self::getTariffs($level_id, $messageInfo['lang'], $sms_operator_id);

        $pageCount      = $messageInfo['page'];
        $mtnNumbers     = getMtnNumbers($numbers);
        $mciNumbers     = getMciNumbers($numbers);
        $rightelNumbers = getRightelNumbers($numbers);
        $taliaNumbers   = getTaliaNumbers($numbers);
        $spadanNumbers  = getSpadanNumbers($numbers);
        $tkcNumbers     = getTkcNumbers($numbers);

        $mtn        = $tariffs['mtn'] * count($mtnNumbers) * $pageCount;
        $mci        = $tariffs['mci'] * count($mciNumbers) * $pageCount;
        $rightel    = $tariffs['rightel'] * count($rightelNumbers) * $pageCount;
        $talia      = $tariffs['talia'] * count($taliaNumbers) * $pageCount;
        $spadan     = $tariffs['spadan'] * count($spadanNumbers) * $pageCount;
        $tkc        = $tariffs['tkc'] * count($tkcNumbers) * $pageCount;
        return $mtn + $mci + $rightel + $talia + $spadan + $tkc;
    }

    public static function resetUserPassword($user)
    {
        $new_password = self::getNewPassword();
        $expire_at = Carbon::now()->addMinutes(settings()->get('PASSWORD_EXPIRE_AFTER'))->format('Y-m-d H:i:00');
        $user->update(['password'=>\Hash::make($new_password),'data->password_expire_at'=>$expire_at]);
        $users_ids = json_decode(Redis::get('reset-password-'.$expire_at));
        if($users_ids) {
            array_push($users_ids, $user->id);
        } else {
            $users_ids = [$user->id];
        }
        Redis::set('reset-password-'.$expire_at, json_encode($users_ids));
        return $new_password;
    }

    public static function appendToRedisArray($arrayKey, $value)
    {
        $values = Redis::get($arrayKey);
        $data = json_decode($values, true);
        $data = array_merge((array) $data, (array) $value);
        Redis::set($arrayKey, json_encode($data));
    }

    public static function dropUserFromResetList($user)
    {
        $expire_at = $user->jsonData('password_expire_at');
        $user->update(['data->password_expire_at'=>'']);
        $users_ids = json_decode(Redis::get('reset-password-'.$expire_at), true);
        if($users_ids) {
            foreach ($users_ids as $key=>$value) {
                if($value == $user->id)
                    unset($users_ids[$key]);
            }
        }
        Redis::set('reset-password-'.$expire_at, json_encode($users_ids));
    }

    public static function resetUsersPasswords()
    {
        $now = Carbon::now()->format('Y-m-d H:i:00');
        $users_ids = json_decode(Redis::get('reset-password-'.$now));
        if($users_ids)
            User::whereIn('id', $users_ids)->update(['password' => 'RESET']);
        Redis::del('reset-password-'.$now);
        return true;
    }

    public static function sendScheduledMessages()
    {
        $now = Carbon::now()->format('Y-m-d H:i:00');
        $sent_message_ids = json_decode(Redis::get('send-message-at-'.$now));
        if($sent_message_ids) {
            $sent_messages = SentMessage::whereIn('id', $sent_message_ids)->with(['deliveries'=>function($query){
                $query->select('id', 'sent_message_id', 'status');
            }, 'user', 'line'])->get();
            foreach ($sent_messages as $sent_message) {
                if($sent_message->status === SentMessageEnum::STATUS_PENDING) {
                    $sent_message->update(['status'=>SentMessageEnum::STATUS_REJECTED_BY_ADMIN]);
                    self::returnBackSendMessageMoney($sent_message);
                    // self::setStatusToAllDeliveries($sent_message->deliveries, DeliveryEnum::STATUS_REJECTED_BY_ADMIN);
                } elseif ($sent_message->status === SentMessageEnum::STATUS_SCHEDULED) {
                    if($sent_message->through == SentMessageEnum::THROUGH_REST) {
                      $numbers = Delivery::select('mobile')->where('sent_message_id', $sent_message->id)->get();
                      if($numbers) {
                        $numbers = $numbers->pluck('mobile')->toArray();
                      } else {
                        $numbers = [];
                      }
                    } else {
                      $numbers = Redis::get('SENT_MESSAGE_ID_'.$sent_message->id.'_PENDING');
                      $numbers = json_decode($numbers, JSON_OBJECT_AS_ARRAY);
                    }
                    $sent_message->update(['status'=>SentMessageEnum::STATUS_ENQUEUED]);
                    if($sent_message->type === SentMessageEnum::TYPE_SMART) {
                        $messages = Redis::get('sent-message-id-'.$sent_message->id.'-pending-messages');
                        $messages = json_decode($messages, JSON_OBJECT_AS_ARRAY);
                        SendSmsJob::dispatch($sent_message, $numbers, $messages);
                        Redis::del('sent-message-id-'.$sent_message->id.'-pending-messages');
                    } else {
                        SendSmsJob::dispatch($sent_message, $numbers);
                    }
                    Redis::del('SENT_MESSAGE_ID_'.$sent_message->id.'_PENDING');
                }
            }
        }
        Redis::del('send-message-at-'.$now);
        // $tag_name = 'زمانبندی ' . jdate('Y-m-d H:i', null, null, null, 'en');
        // $tag = Tag::where('name', $tag_name)->first();
        // if($tag)
        // {
        //     foreach($tag->contacts as $contact)
        //     {

        //     }
        // }
        return true;
    }

    public static function getNewPassword()
    {
        return rand(100000,999999);
    }

    public static function to_pg_array($set) {
        settype($set, 'array'); // can be called with a scalar or array
        $result = array();
        foreach ($set as $t) {
            if (is_array($t)) {
                $result[] = self::to_pg_array($t);
            } else {
                $t = str_replace('"', '\\"', $t); // escape double quote
                if (! is_numeric($t)) // quote only non-numeric values
                    $t = '"' . $t . '"';
                $result[] = $t;
            }
        }
        return '{' . implode(",", $result) . '}'; // format
    }

    public static function toPgArray($set) {
        settype($set, 'array'); // can be called with a scalar or array
        $result = array();
        foreach ($set as $t) {
            if (is_array($t)) {
                $result[] = self::to_pg_array($t);
            } else {
                $t = str_replace('"', '\\"', $t); // escape double quote
                if (! is_numeric($t)) // quote only non-numeric values
                    $t = '"' . $t . '"';
                $result[] = $t;
            }
        }
        return '[' . implode(",", $result) . ']'; // format
    }

    public static function getOperatorsPriceList($level_id, $sms_operator_id)
    {
        $level_id = $level_id ? $level_id : auth('web')->user()->level_id;
        $tariffs = Cache::remember('tariffs', 60*24 ,function () use ($level_id) {
            return DB::table('tariffs')
                ->select(DB::raw('tariffs.*, tariffs.sms_operator_id, mobile_operators.name as mobile_name'))
                ->join('levels', 'tariffs.level_id', 'levels.id')
                ->join('sms_operators', 'tariffs.sms_operator_id', 'sms_operators.id')
                ->join('mobile_operators', 'tariffs.mobile_operator_id', 'mobile_operators.id')
                ->get();
        });
        $mtn_tariff = $tariffs
            ->where('mobile_name', 'mtn')
            ->where('level_id', $level_id)
            ->where('sms_operator_id', $sms_operator_id)
            ->first();
        $mci_tariff = $tariffs
            ->where('mobile_name', 'mci')
            ->where('level_id', $level_id)
            ->where('sms_operator_id', $sms_operator_id)
            ->first();
        $rightel_tariff = $tariffs
            ->where('mobile_name', 'mci')
            ->where('level_id', $level_id)
            ->where('sms_operator_id', $sms_operator_id)
            ->first();
        $result = ['price_list'=>
            [
                'mtn'=>['fa'=>$mtn_tariff->price_fa, 'en'=>$mtn_tariff->price_en],
                'mci'=>['fa'=>$mci_tariff->price_fa, 'en'=>$mci_tariff->price_en],
                'rightel'=>['fa'=>$rightel_tariff->price_fa, 'en'=>$rightel_tariff->price_en],
            ]
        ];
        return $result;
    }

    public static function getMobileOperator($number)
    {
        if(getMtnNumbers([$number]) != null)
            return 'mtn';
        elseif(getMciNumbers([$number]) != null)
            return 'mci';
        elseif(getRightelNumbers([$number]) != null)
            return 'rightel';
        elseif(getTaliaNumbers([$number]) != null)
            return 'talia';
        elseif(getSpadanNumbers([$number]) != null)
            return 'spadan';
        elseif(getTkcNumbers([$number]) != null)
            return 'tkc';
        else
            return 'mci'; //for unknown mobile operator numbers
    }

    public static function returnBackSendMessageMoney($sent_message, $reject_by = 'admin')
    {
        $tranaction_type = TransactionEnum::TYPE_RETURN_MONEY;
        $remain_amount = $sent_message->user->getCurrentCredit() + ($sent_message->price);
        if($reject_by === 'admin') {
            $description = 'عدم تایید پیام  با شناسه '.toFarsiNumber($sent_message->id).' توسط مدیر - '.' بازگشت وجه '. toFarsiNumber($sent_message->price) . ' ' .settings()->get('MONEY_UNIT');
            if($sent_message->employer_id) {
                $tranaction_type = TransactionEnum::TYPE_EMPLOYEE_RETURN_MONEY;
                $remain_amount = $sent_message->user->getCurrentCreditAsEmployee($sent_message->employer_id) + ($sent_message->price);
            }
        } elseif ($reject_by === 'user') {
            $description = 'لغو پیام  با شناسه '.toFarsiNumber($sent_message->id).' توسط کاربر - '.' بازگشت وجه '. toFarsiNumber($sent_message->price) . ' ' .settings()->get('MONEY_UNIT');
            if($sent_message->employer_id) {
                $tranaction_type = TransactionEnum::TYPE_EMPLOYEE_RETURN_MONEY;
                $remain_amount = $sent_message->user->getCurrentCreditAsEmployee($sent_message->employer_id) + ($sent_message->price);
            }
        }
        $sent_message->user->transactions()->create([
            'transactionable_id' => $sent_message->id,
            'transactionable_type' => TransactionEnum::TYPE_SEND_SMS,
            'type' => $tranaction_type,
            'description' => $description,
            'amount' => $sent_message->price,
            'envoy_id' => $sent_message->envoy_id,
            'envoy_amount' => $sent_message->envoy_price,
            'envoy_remain_amount' => $sent_message->envoy->user->getCurrentCredit() + $sent_message->envoy_price,
            'remain_amount' => $remain_amount,
            'employer_id' => $sent_message->employer_id,
            'confirmed' => 1,
        ]);

    }

    public static function removeHttpFromUrl($url)
    {
        return $url = preg_replace("(^https?://)", "", $url );
    }

    public static function shortUrl($url, $removeHttp = false)
    {
        // $client = new GuzzleHttp\Client();
        // $google_api_key = 'AIzaSyASUpNvT4tQOlpBtzr4FqaBV2WPya-KTTo';
        // $res = $client->request('POST', 'https://www.googleapis.com/urlshortener/v1/url', [
        //     'headers' => ['Content-Type' => 'application/json'],
        //     'query' => [
        //         'key' => $google_api_key
        //     ],
        //     'body' => json_encode(['longUrl'=>$url])
        // ]);
        // $responseJson = $res->getBody()->getContents();
        // $short_url = json_decode($responseJson, true)['id'];
        // if($removeHttp)
        $short_url = self::removeHttpFromUrl($url);
        return $short_url;
    }

    public static function setStatusToAllDeliveries($deliveries, $status)
    {
        foreach($deliveries as $delivery) {
            $delivery->status = $status;
        }
        Delivery::updateAll($deliveries->toArray());
    }

    public static function sendDueDateMessages()
    {
        $now = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:00');
        $contacts = DB::select("select * from due_date_contacts('$now', '$time')");
        if(!$contacts)
            return false;
        $contacts = json_decode(json_encode($contacts), true);
        foreach ($contacts as $contact) {
            // don't send SMS at Night(after 2 PM) if today is the Due Date
            if((int)Carbon::now()->format('H') >= 14 && $contact['cday_index'] === '0')
                continue;
            $text = $contact['cmessage'];
            $user_id = $contact['cuser_id'];
            $line_id = $contact['cline_id'];
            $line = Cache::remember('due-date-line-id-'.$line_id, 10,function() use($line_id) {
                return Line::find($line_id);
            });
            if(!$line)
                continue;
            $user = Cache::remember('due-date-user-id-'.$user_id, 10,function() use($user_id) {
                return User::find($user_id);
            });
            $all_lines = Cache::remember('due-date-user-'.$user_id.'-lines', 10,function() use($user) {
                return $lines = $user->allLines();
            });
            $line_check = $all_lines->where('id', $contact['cline_id'])->first();
            if(!$line_check)
                continue;
            if($contact['cday_index'] === '0')
                $day_name = 'امروز';
            elseif($contact['cday_index'] === '1')
                $day_name = 'فردا';
            else
                $day_name = 'پس‌فردا';
            $text = str_replace('#نام#', $contact['cfirst_name'], $text);
            $text = str_replace('#نام_خانوادگی#', $contact['clast_name'], $text);
            $text = str_replace('#مبلغ#', toFarsiNumber(number_format($contact['camount'])).' '.settings()->get('MONEY_UNIT'), $text);
            $text = str_replace('#روز_سررسید#', $day_name, $text);
            $text = str_replace('#روز_انقضا#', $day_name, $text);
            $text = str_replace('#تاریخ_سررسید#', jdate('Y/m/d', strtotime($contact['cday'.$contact['cday_index']])), $text);
            $text = str_replace('#تاریخ_انقضا#', jdate('Y/m/d', strtotime($contact['cday'.$contact['cday_index']])), $text);
            $mobile = getRealMobileNumber($contact['cmobile']);
            CreateAndSendSmsJob::dispatch($user, $line, $text, [$mobile]);
        }
        return true;
    }

    public static function cleanTempDirectory()
    {
        \File::cleanDirectory(public_path('temp'));
        // self::cleanUsersWebserviceLogs();
        self::cleanUsersWebhookLogs();
    }

    public static function cleanUsersWebserviceLogs()
    {
        $user_ids = WebserviceLog::select('user_id')->groupBy('user_id')->get()->pluck('user_id')->toArray();
        $success = [];
        $error = [];
        $remove_errors = false;
        $day = jdate('d', strtotime(now()), null, null, 'en');
        if( (int) $day === 1) {
            $remove_errors = true;
            $created_at = now()->subDay()->format('Y-m-d 23:59:59');
        }
        foreach($user_ids as $id) {
            $success_result = WebserviceLog::select('id')
                    ->where('user_id', $id)
                    ->where('response_status_code', 200)
                    ->orderBy('id', 'desc')
                    ->take(config('global.MAX_LOG_COUNT'))
                    ->get()
                    ->pluck('id')
                    ->toArray();
            $success = array_merge($success, $success_result);
        }
        if($remove_errors) {
            WebserviceLog::where('created_at', '<=', $created_at)
                ->where('response_status_code', '!=', 200)
                ->delete();
        }
        if($success) {
            $ids = self::changeArrayToParenthesisString(array_merge($success, $error));
            DB::statement("DELETE FROM webservice_logs WHERE id NOT IN $ids");
            DB::statement("vacuum webservice_logs");
        }
    }

    public static function cleanUsersWebhookLogs()
    {
        $user_ids = WebhookLog::select('user_id')->groupBy('user_id')->get()->pluck('user_id')->toArray();
        $success = [];
        $error = [];
        $remove_errors = false;
        $day = jdate('d', strtotime(now()), null, null, 'en');
        if( (int) $day === 1) {
            $remove_errors = true;
            $created_at = now()->subDay()->format('Y-m-d 23:59:59');
        }
        foreach($user_ids as $id) {
            $success_result = WebhookLog::select('id')
                    ->where('user_id', $id)
                    ->where('status_code', 200)
                    ->orderBy('id', 'desc')
                    ->take(config('global.MAX_LOG_COUNT'))
                    ->get()
                    ->pluck('id')
                    ->toArray();
            $success = array_merge($success, $success_result);
        }
        if($remove_errors) {
            WebhookLog::where('created_at', '<=', $created_at)
                ->where('status_code', '!=', 200)
                ->delete();
        }
        if($success) {
            $ids = self::changeArrayToParenthesisString(array_merge($success, $error));
            DB::statement("DELETE FROM webhook_logs WHERE id NOT IN $ids");
            DB::statement("vacuum webhook_logs");
        }
    }

    /**
     * @param $path Excel File Path
     * @param $noHeading Does Excel File Has No Heading Row?
     * @param $mergeHeadings It will merge headings with entries
     */
    public static function readExcelFile($path, $noHeading = true, $mergeHeadings = false)
    {
        $hasHeading = true;
        $twoLoop = false;
        $headings = [];
        $entries = [];
        $mobileColumnIndex = null;
        \Excel::filter('chunk')->noHeading($noHeading)->load($path)->chunk(100000, function ($reader) use(&$entries, &$hasHeading, $noHeading, &$headings, &$mobileColumnIndex, &$twoLoop) {
            foreach ($reader->toArray() as $key=>$row) {
                if($key == 0) {
                    $result     = self::excelHasHeading($key, $row);
                    $hasHeading = $result['hasHeading'];
                    $twoLoop    = $result['twoLoop'];
                    $headings   = $result['headings'];
                    $mobileColumnIndex   = $result['mobileColumnIndex'];
                    if(!$twoLoop && $hasHeading) continue;
                }
                if($twoLoop) { // For 2D Arrays
                    foreach($row as $newKey=>$newRow) {
                        if(($newKey == 0 && $hasHeading) || ! $newRow ) continue;
                        $entries["$newKey"] = $newRow;
                    }
                } else { // For 1D Arrays
                    $entries["$key"] = $row;
                }
            }
        }, $shouldQueue = false);
        if($mergeHeadings) {
            $new = [];
            foreach($entries as $row) {
                if(count($row) != count($headings)) continue;
                $new[] = array_combine($headings, $row);
            }
            $entries = $new;
        }
        return [
            'entries' => $entries,
            'headings' => $headings,
            'hasHeading' => $noHeading ? $hasHeading : true,
            'twoLoop' => $twoLoop,
            'mobileColumnIndex' => $mobileColumnIndex,
        ];
    }

    public static function getPriceOfPeerToPeerSms($level_id = null, $numbers, $messages, $sms_operator_id)
    {
        $total = 0;
        foreach($numbers as $key=>$number) {
            $price = 0;
            $messageInfo = getSmsMessageInfo($messages[$key]);
            $price += self::getPriceOfThisNumber($level_id, $number, $messageInfo['lang'], $sms_operator_id);
            $price *= $messageInfo['page'];
            $total += $price;
        }
        return $total;
    }

    public static function excelHasHeading($key, $row): array
    {
        $hasHeading = true;
        $twoLoop = false;
        $headings = [];
        $mobileColumnIndex = null;
        foreach($row as $rowKey=>$rowItem) {
            if(is_array($rowItem)) {
                $twoLoop = true;
                foreach($rowItem as $newKey=>$item) {
                    $headings[$newKey] = trim($item);
                }
                foreach($rowItem as $newKey=>$item) {
                    if( (int) toEngNumber($item) ) {
                        if(getRealMobileNumber($item)) {
                            if(is_numeric($newKey))
                                $mobileColumnIndex = $newKey+1;
                            $mobileColumnIndex = $newKey;
                        }
                        $hasHeading = false;
                        break 2;
                    }
                    break 1;
                }
                if($hasHeading && ! $mobileColumnIndex) {
                    foreach($row[1] as $newKey=>$item) {
                        if( (int) toEngNumber($item) ) {
                            if(getRealMobileNumber($item)) {
                                if(is_numeric($newKey))
                                    $mobileColumnIndex = $newKey+1;
                                $mobileColumnIndex = $newKey;
                                break 2;
                            }
                        }
                    }
                    break;
                }
            } else {
                $headings[$rowKey] = $rowItem;
                if( (int) toEngNumber($rowItem) ) {
                    if(getRealMobileNumber($rowItem)) {
                        if(is_numeric($rowKey))
                          $mobileColumnIndex = $rowKey+1;
                        $mobileColumnIndex = $rowKey;
                    }
                    $hasHeading = false;
                    break;
                }
                if( $rowKey+1 === count($row) && $hasHeading) {
                    if( ! is_array($row[0])) break;
                    foreach($row[1] as $newKey=>$item) {
                        if( (int) toEngNumber($item) ) {
                            if(getRealMobileNumber($item)) {
                                if(is_numeric($newKey))
                                    $mobileColumnIndex = $newKey+1;
                                $mobileColumnIndex = $newKey;
                                break 2;
                            }
                        }
                    }
                }
            }
        }
        return [
            'hasHeading' => $hasHeading,
            'twoLoop'    => $twoLoop,
            'headings'   => $headings,
            'mobileColumnIndex'   => $mobileColumnIndex,
        ];
    }

    public static function createPgEnumType($table, $column, array $types, $default = null)
    {
        $enum_name = 'enum_'.$table.'_'.$column;
        $enums = MyHelper::changeArrayToParenthesisString($types, true);
        DB::statement("DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = '$enum_name') THEN
                    CREATE TYPE $enum_name AS ENUM $enums;
                END IF;
            END$$;");
        if($default) {
            DB::statement("ALTER TABLE $table ALTER COLUMN $column TYPE $enum_name USING $column::$enum_name, ALTER COLUMN $column DROP NOT NULL, ALTER COLUMN $column SET DEFAULT '$default'");
        } else {
            DB::statement("ALTER TABLE $table ALTER COLUMN $column TYPE $enum_name USING $column::$enum_name, ALTER COLUMN $column DROP NOT NULL");
        }
    }

    public static function addPgEnumType($table, $column, array $types, $default = null)
    {
        $enum_name = 'enum_'.$table.'_'.$column;
        $enums = MyHelper::changeArrayToParenthesisString($types, true);
        DB::statement("DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = '$enum_name') THEN
                    CREATE TYPE $enum_name AS ENUM $enums;
                END IF;
            END$$;");
        if($default)
            DB::statement("ALTER TABLE {$table} ADD COLUMN {$column} {$enum_name} DEFAULT '{$default}'");
        else
            DB::statement("ALTER TABLE {$table} ADD COLUMN {$column} {$enum_name} DEFAULT NULL");
    }

    public static function getCronType($expression)
    {
        $cronArray = explode(' ', $expression);
        if($cronArray[2] === '*' && $cronArray[3] === '*' && $cronArray[4] === '*')
            return 'daily';
        elseif($cronArray[2] === '*' && $cronArray[3] === '*')
            return 'weekly';
        elseif($cronArray[3] === '*' && $cronArray[4] === '*')
            return 'monthly';
        return 'yearly';

    }

    public static function getCronDateDiffs($expression, $from, $to)
    {
        $cron_type = self::getCronType($expression);
        switch ($cron_type) {
            case 'daily':
                return $from->diffInDays($to);
                break;
            case 'weekly':
                return $from->diffInWeeks($to);
                break;
            case 'monthly':
                return $from->diffInMonths($to);
                break;
            default:
                return $from->diffInYears($to);
        }
    }

    public static function getCronDates($expression, $start_jdate, $end_jdate)
    {
        $from = convertJalaliToGeorgian($start_jdate, false, true);
        $to = convertJalaliToGeorgian($end_jdate, false, true);
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);
        $diff = self::getCronDateDiffs($expression, $from, $to);
        $cronType = self::getCronType($expression);
        if($cronType === 'monthly') {
            list($year, $month, $day) = explode('/', $start_jdate);
            list($year2, $month2, $day2) = explode('/', $end_jdate);
            list($minute, $hour, $expr_day, $expr_month) = explode(' ', $expression);
            $j = ((int) $month + $diff);
            $first_month = (int)$month;
            for($i = (int)$month; $i <= $j; $i++) {
                if($i == $j) {
                    if($day2 < $expr_day) {
                        break;
                    }
                } elseif($i == $first_month) {
                    if($day > $expr_day) {
                        if($month < 12) {
                            $month++;
                        } else {
                            $year++;
                            $month = 01;
                        }
                        continue;
                    }
                }
                $jdate = $year.'/'.sprintf('%02d', $month).'/'.$expr_day. ' '.sprintf('%02d', $hour).':'.sprintf('%02d', $minute).':00';
                $dates[] = convertJalaliToGeorgian($jdate);
                if($month < 12) {
                    $month++;
                } else {
                    $year++;
                    $month = 01;
                }
            }
        }
        elseif($cronType === 'yearly') {
            list($year, $month, $day) = explode('/', $start_jdate);
            list($minute, $hour, $orig_day, $orig_month) = explode(' ', $expression);
            for($i = 0; $i <= $diff; $i++) {
                if($i == 0) {
                    if($orig_month < $month || $orig_day < $day) {
                        $year++;
                        continue;
                    }
                }
                $jdate = $year.'/'.sprintf('%02d', $orig_month).'/'.sprintf('%02d', $orig_day). ' '.sprintf('%02d', $hour).':'.sprintf('%02d', $minute).':00';
                $year++;
                $dates[] = $jdate;
            }
        } elseif($cronType === 'weekly') {
            $cron = CronExpression::factory($expression);
            foreach ($cron->getMultipleRunDates($diff) as $date) {
                $dt = Carbon::parse($date->format('Y-m-d H:i:s'))->subDay()->format('Y-m-d H:i:s');
                $dates[] =  $dt;
            }
        } elseif($cronType === 'daily') {
            $cron = CronExpression::factory($expression);
            foreach ($cron->getMultipleRunDates($diff) as $date) {
                $dt = Carbon::parse($date->format('Y-m-d H:i:s'))->subDay()->format('Y-m-d H:i:s');
                $dates[] =  $dt;
            }
        }
        return $dates;
    }

    public static function exportDataTableToExcel($rows, $file_name,  $title = 'SabaNovin', $chunk_size = 10000)
    {
        $alphabet = range('A', 'Z');
        $rows = array_slice($rows, 0, 500000);
        $export_chunks = array_chunk($rows, $chunk_size);
        foreach ( $export_chunks as $key=>$chunk ) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $activeSheet = $spreadsheet->getActiveSheet();
            $spreadsheet->getActiveSheet()->setTitle($title);
            $titles = array_keys($chunk[0]);
            foreach($titles as $k=>$title) {
                $spreadsheet->getActiveSheet()->getColumnDimension("{$alphabet[$k]}")->setWidth(20);
                $activeSheet->setCellValueExplicit("{$alphabet[$k]}1" , $title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
            for($i = 1; $i <= count($chunk); $i++) {
                $values = array_values($chunk[$i-1]);
                foreach($values as $key2=>$value) {
                    $index = $i+1;
                    $activeSheet->setCellValueExplicit("{$alphabet[$key2]}{$index}" , $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                }
            }
            $writer = new Xlsx($spreadsheet);
            $files[$key] = public_path('temp/'.$file_name.'_'.auth()->user()->id.$key.'.xlsx');
            $writer->save($files[$key]);
        }
        $zipFileName = md5(auth()->user()->id.$file_name).'.zip';
        $zipPath = public_path("/temp/{$zipFileName}");
        Zipper::make($zipPath)->add($files)->close();
        $token = md5(time());
        Cache::put($token, '1', 5);
        return [
            'token' => $token,
            'file'  => $zipFileName
        ];
    }

    public static function returnMoneyBlackListsTable()
    {
        $sentMessages = TempBlackList::select('sent_message_id')
                ->distinct('sent_message_id')
                ->get()
                ->pluck('sent_message_id')
                ->toArray();
        foreach($sentMessages as $sentMessageId) {
            $sentMessage = SentMessage::find($sentMessageId);
            ReturnMoneyBackJob::dispatch($sentMessage)->onQueue('send_sms');
        }

    }

    public static function getWebServiceRequestToArray($request, $response_body, $status_code = 200, $status_text = '')
    {
        if($request->is('*.xml'))
            $format = 'XML';
        else {
            $response_body = json_encode($response_body);
            $format = 'JSON';
        }
        $request_method = $request->getMethod();
        if($request_method !== 'POST')
            $request_method = 'GET';
        $restful_api_key = $request->route()->parameters['api_key'];
        $request_body = self::getPropperRequestBody($request);
        $webservice_log = [
            'user_id' => $request->user()->id,
            'url'     => $request->url(),
            'api_key' => $restful_api_key,
            'webservice_method'  => 'REST',
            'request_method'     => $request_method,
            'action'  => explode('@', $request->route()->action['uses'])[1],
            'request_body'     => $request_body,
            'response_body'    => $response_body,
            'response_format'  => $format,
            'response_status_code'=>$status_code,
            'response_status_text'=>$status_text,
            'ip'      => $request->getClientIp(),
        ];
        return $webservice_log;
    }

    public static function getPropperRequestBody($request)
    {
       $res = $request->all();
       $keys = array_keys($res);
       $result = preg_grep('/\/v1\/sa\d+:/', $keys);
       if(!$result) return false;
       $key = array_keys($result);
       $remove_key = $keys[$key[0]];
       unset($res[$remove_key]);
       return json_encode($res);
    }
}
