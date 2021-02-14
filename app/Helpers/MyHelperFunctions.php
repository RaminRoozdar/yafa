<?php
    function array_mapper($key)
    {
      $array = array(
        'admin'   => 'مدیر',
        'admins'  => 'مدیر',
        'lists'   => 'لیست',
        'list'    => 'لیست',
        'user'    => 'کاربر',
        'users'   => 'کاربران',
      );
      return $array[$key];
    }

    function unathorizedResponse()
    {
        return response()->json(['status'=>['code'=>403, 'message'=>'عملیات غیر مجاز']], 403);
    }

    function number_type_mapper($key)
    {
        $array = array(
            'sa'   => 'اشتراکی - تبلیغاتی',
            'ss'  => 'اشتراکی - خدماتی',
            'da'   => 'اختصاصی - تبلیغاتی',
            'ds'    => 'اختصاصی - خدماتی',
        );
        return $array[$key];
    }

    function status_color_mapper($key)
    {
      $array = array(
        'pending' => 'warning',
        'successful' => 'success',
        'success' => 'success',
        'failed' => 'danger',
        'confirmed' => 'success',
        'disconfirmed' => 'danger',
        'cancel' => 'default',
        'OK' => 'success',
        'NOK' => 'danger',
        'expired' => 'danger',
        'active' => 'success',
        'unpaid' => 'warning',
        'finished' => 'default',
        'rejected_by_admin' => 'danger',
        '' => '',
      );
      return $array[$key];
    }

    function show_array($array, $die = false)
    {
        echo '<pre>'.print_r($array, true).'</pre>';
        if($die)
            die();
    }

    function gateway_mapper($id) {

        $array = array(
            '1' => 'بانک ملت',
            '2' => 'بانک سامان',
            '3' => 'زرین پال',
            '4' => 'بانک پاسارگاد',
            '' => ''
        );
        return $array[$id];
    }

    function os_version_mapper($version) {

        $array = array(
            '5.0' => '2000',
            '5.1' => 'XP',
            '5.2' => 'XP',
            '6.0' => 'Vista',
            '6.1' => '7',
            '6.2' => '8',
            '6.3' => '8.1',
            '10.0' => '10',
            '' => ''
        );
        return $array[$version];
    }

    function valid_mapper($id) {
        $array = array(
            '0' => 'تکراری',
            '1' => 'صحیح',
        );
        return $array[$id];
    }

    function answerableMapper($type) {
        $array = [
            'AutoResponder' => 'پاسخگوی خودکار',
            'Poll' => 'مسابقه/نظرسنجی',
        ];
        return $array[$type];
    }

    function is_mobile_mapper($id) {
        $array = array(
            '1' => 'موبایل',
            '2' => 'تبلت',
            '3' => 'کامپیوتر',
        );
        return $array[$id];
    }

    function secret_ip($ip)
    {
        $ip_array = explode('.', $ip);
        $sub_ip = $ip_array[2]. '.' . $ip_array[3] . '.*.*';
        return $sub_ip;
    }

    function bank_mapper($id)
    {
        $array = array(
            '1' => 'ملت',
            '2' => 'ملی',
            '3' => 'تجارت',
            '4' => 'سپه',
            '5' => 'پارسیان',
            '6' => 'پاسارگاد',
            '7' => 'اقتصاد نوین',
            '8' => 'سامان',
            '9' => 'پست بانک',
            '10' => 'توسعه صادرات',
            '11' => 'رفاه کارگران',
            '12' => 'سامان',
            '13' => 'سرمایه',
            '14' => 'سینا',
            '15' => 'صادرات',
            '16' => 'صنعت و معدن',
            '17' => 'قرض الحسنه مهر ایران',
            '18' => 'بانک قرض الحسنه مهر رسالت',
            '19' => 'کارآفرین',
            '20' => 'کشاورزی',
            '21' => 'مسکن',
            '22' => 'بانک دی',
            '23' => 'بانک انصار',
            '24' => 'بانک ایران زمین',
            '25' => 'بانک گردشگری',
            '26' => 'بانک حکمت ایرانیان',
            '27' => 'بانک توسعه و تعاون',
            '28' => 'بانک قوامین',
            '29' => 'توسعه کوثر',
            '30' => 'بانک شهر',
            '31' => 'موسسه اعتباری عسکریه',
            '32' => 'بانک آینده',
        );
        return $array[$id];
    }

    function desc_generator($amount, $type, $campaign_name = null)
    {
        $amount = farsi_number(number_format($amount));
        switch ($type) {
            case 'campaign' :
                $desc = "کسر مبلغ $amount تومان از حساب بابت کمپین $campaign_name";
                break;
            case 'withdraw' :
                $desc = "برداشت مبلغ $amount تومان";
                break;
            case 'deposit' :
                $desc = "افزایش اعتبار به مبلغ $amount تومان";
                break;
            case 'return_amount' :
                $desc = "بازگشت مبلغ  $amount تومان بابت کمپین $campaign_name";
                break;
            default:
                $desc = '';
        }
        return $desc;
    }

    function toFarsiNumber($number)
    {
        $number = str_replace("1","۱",$number);
        $number = str_replace("2","۲",$number);
        $number = str_replace("3","۳",$number);
        $number = str_replace("4","۴",$number);
        $number = str_replace("5","۵",$number);
        $number = str_replace("6","۶",$number);
        $number = str_replace("7","۷",$number);
        $number = str_replace("8","۸",$number);
        $number = str_replace("9","۹",$number);
        $number = str_replace("0","۰",$number);
        return $number;
    }

    function toEngNumber($number)
    {
        $number = str_replace("۱","1",$number);
        $number = str_replace("١","1",$number);
        $number = str_replace("۲","2",$number);
        $number = str_replace("٢","2",$number);
        $number = str_replace("۳","3",$number);
        $number = str_replace("٣","3",$number);
        $number = str_replace("۴","4",$number);
        $number = str_replace("٤","4",$number);
        $number = str_replace("۵","5",$number);
        $number = str_replace("٥","5",$number);
        $number = str_replace("۶","6",$number);
        $number = str_replace("٦","6",$number);
        $number = str_replace("۷","7",$number);
        $number = str_replace("٧","7",$number);
        $number = str_replace("۸","8",$number);
        $number = str_replace("٨","8",$number);
        $number = str_replace("۹","9",$number);
        $number = str_replace("٩","9",$number);
        $number = str_replace("۰","0",$number);
        $number = str_replace("٠","0",$number);
        return $number;
    }

    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'سال',
            'm' => 'ماه',
            'w' => 'هفته',
            'd' => 'روز',
            'h' => 'ساعت',
            'i' => 'دقیقه',
            's' => 'ثانیه',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v;
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' قبل' : 'لحظاتی قبل';
    }

    function is_mobile()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];

        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
            return true;
        return false;
    }

    function get_ip_country($ip)
    {
        try
        {
            $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
            return $details->country; // "IR"
        } catch (Exception $e) {
            return Null;
        }
    }

    function wordifyNum($number) {
        $array = ['صفر', 'یک','دو','سه','چهار','پنج','شش','هفت','هشت','نه','ده','یازده','دوازده','سیزده'
 ,'چهارده','پانزده','شانزده','هفده','هجده','نوزده','بیست','بیست و یک','بیست و دو','بیست و سه'
 ,'بیست و چهار','بیست و پنج','بیست و شش','بیست و هفت','بیست و هشت','بیست و نه','سی','سی و یک'];

        return $array[$number];
    }

    function sort_users_by($column, $body)
    {
        $direction = (\Request::get('direction') == 'asc') ? 'desc' : 'asc';
        $aria_sort = (\Request::get('direction') == 'asc') ? 'descending' : 'ascending';
        $sorting = 'sorting_'.strtolower($direction);
        return '<a href="'. route('users', ['sortBy' => $column, 'direction' => $direction]) . '">' . $body .'</a>';
//        return '<th class="'.$sorting.'" aria-sort="'.$aria_sort.'" tabindex="0" aria-controls="sample_2" rowspan="1" colspan="1" style="width: 91px;"><a href='. route('users', ['sortBy' => $column, 'direction' => $direction]) . '>' . $body .'</a></th>';
    }

/**
 * @param $amount numbers with commas like 100,000,000 - Also change farsi number to English
 * @return int    remmoved commas like 100000000
 */
    function get_real_amount($amount)
    {
        $amount = toEngNumber($amount);
        return (int)preg_replace("/([^0-9\\.])/i", "", $amount);
    }

/**
 * @param $file   For Example $file = Input::file('image');
 * @return mixed    It returns The File Extension
 */
    function getFileExtension($file)
    {
        if($file)
            return pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        return false;
    }

    function isValidEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function removeHttpFromUrl($url)
    {
        return $url = preg_replace("(^https?://)", "", $url );
    }

    function removeAtSignFromString($str)
    {
        return $str = preg_replace('/[@]/', "", $str );
    }

    function addZeroPrefix($number, $key = null)
    {
        return sprintf("%02d", $number);
    }

    function ttruncat($text,$numb) {
        if (strlen($text) > $numb) {
            $text = substr($text, 0, $numb);
            $text = substr($text,0,strrpos($text," "));
            $etc = " ...";
            $text = $text.$etc;
        }
        return $text;
    }

    /**
     * @param JalaliDate String is a Jalali Date Like "۱۳۹۵/۱۲/۲۱ ۲۲:۱۵:۳۲"
     * @param $endOfDay Boolean
     * @param $disableTime Boolean
     * @return String GeorgianDate It will return "2017-03-11 22:15:32"
     */
    function convertJalaliToGeorgian($jDateTime, $endOfDay = false, $disableTime = false)
    {
      $jDate = toEngNumber(explode(' ', $jDateTime)[0]);
      if(isset(explode(' ', $jDateTime)[1])) {
          $time  = toEngNumber(explode(' ', $jDateTime)[1]);
          if(strlen($time) == 5) {
              $time .= ':00';
          }
      } else {
          if($endOfDay)
            $time  = '23:59:59';
          else
            $time  = '00:00:00';
      }
      $arr = explode('/', str_replace('-', '/', $jDate));
      $gDateArray = jalali_to_gregorian($arr[0], $arr[1], $arr[2]);
      $gDate = array_map('addZeroPrefix', $gDateArray);
      $gDate = implode('-', $gDate);
      if($disableTime)
        $dDateTime = $gDate;
      else
        $dDateTime = $gDate . ' ' . $time;
      return $dDateTime;
    }

    function getJalaliDateNoSlashes()
    {
        return toEngNumber(jdate('YmdHis'));
    }

    function getJalaliDateRandomTil()
    {
        return toEngNumber(jdate('YmdHis')).rand(0,99);
    }

    function spfView($view, $data = [], $mergeData = [])
    {
        return false;;
        if(array_key_exists('dataTable', $data)) {
           $dataTable = $data['dataTable'];
           $sections = $dataTable->render($view, $data)->renderSections();
           $sections = addSlashesAndRemoveLines($sections);
        } else {
            $sections = addSlashesAndRemoveLines(view($view, $data)->renderSections());
        }
        $output = '{
            "title": "'.$sections['title'].'",
            "head": "'.$sections['head'].'",
            "body": {
              "spf-page-content": "'.$sections['content'].'"
            },
            "foot": "'.$sections['script'].'"
        }';

        return $output;
    }

    function removeDecimalDot($number)
    {
        return explode('.', $number)[0];
    }

    function replaceDecimalDot($number, $delimiter = '/')
    {
        return str_replace('.', $delimiter, $number);
    }

    function addSlashesAndRemoveLines($sections)
    {
        if (is_array($sections))
        {
            foreach($sections as $key => $var)
            {
                $result[$key] = addcslashes($var, '"');
//                $result[$key] = preg_replace('/(\>)\s*(\<)/m', '$1$2', $result[$key]);
                $result[$key] = str_replace(["\r","\n"],"", $result[$key]);
            }
            return $result;
        }
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function getNewRestfulApiKey($userid = false) {
        $user_id = (auth()->check()) ? auth()->user()->id : $userid;
        $api_key = 'sa'.crc32($user_id+(int) config('global.SALT')).':'.generateRandomString(36);
        return $api_key;
    }

    function getUserLevelMapper($level) {
        $mapper = [
            'blue' => 'آبی',
            'silver' => 'نقره‌ای',
            'gold' => 'طلایی',
            'platinum' => 'پلاتینیوم',
        ];
        return $mapper[$level];
    }

    function getRealMobileNumber($mobile)
    {
        $pattern = '/(0|\+98|0098)?((93[0|3|5|6|7|8|9]{1}[0-9]{7})|(90[1-5]{1}[0-9]{7})|((91[0-9]{1}[0-9]{7})|(99[0|1|2|4|9][0-9]{7}))|(92[0-9]{1}[0-9]{7}))|(932[0-9]{7})|(931[0-9]{7})|(934[0-9]{7})/i';
        if(preg_match($pattern, toEngNumber($mobile), $match)) {
            return $match[count($match)-1];
        }
        return false;
    }

/**
 * @param $message SMS message text
 * @return array|bool Return message Language and pages count
 */
function getSmsMessageInfo($message)
{
    if(!trim($message))
        return false;
    $messageInfo = [];
    $pattern = '/[\x{600}-\x{06FF}]/iu';
    if(preg_match($pattern, $message, $match)) {
        $messageInfo['lang'] = 'fa';
        $length = mb_strlen($message);
            if($length <= 70) {
                $messageInfo['page'] = 1;
            } else if($length <= 134) {
                $messageInfo['page'] = 2;
            } else if($length <= 201) {
                $messageInfo['page'] = 3;
            } else {
                $extra = 0;
                $count = $length / 67;
                if(is_float($count)) {
                    $extra = (int) floor($count) - 3;
                    $messageInfo['page'] = 4 + $extra;
                } else {
                    $messageInfo['page'] = $count;
                }
            }
    } else {
        $length = mb_strlen($message);
        $messageInfo['lang'] = 'en';
        if(strlen($message) <= 160) {
            $messageInfo['page'] = 1;
        } else if(strlen($message) <= 306) {
            $messageInfo['page'] = 2;
        } else if(strlen($message) <= 459) {
            $messageInfo['page'] = 3;
        } else {
            $extra = 0;
            $count = $length / 153;
            if(is_float($count)) {
                $extra = (int)floor($count) - 3;
                $messageInfo['page'] = 4 + $extra;
            } else {
                $messageInfo['page'] = $count;
            }
        }
    }
    return $messageInfo;
}

function genderMapper($key)
{
    $array = [
        'male'   => 'MALE',
        'female' => 'FEMALE',
        'آقا'    => 'MALE',
        'آقای'   => 'MALE',
        'اقا'    => 'MALE',
        'اقای'   => 'MALE',
        'مرد'    => 'MALE',
        'خانم'   => 'FEMALE',
        'زن'     => 'FEMALE',
    ];
    return $array[trim(strtolower($key))];
}

function getNewApiToken($userid = false) {
    // return 'L4we5UtQBsLfmc4UGw2pCIIrNLmLPmIzAwBezascymd5SA6cJz1BLqDpphVi';
    $user_id = (auth()->check()) ? auth()->user()->id : $userid;
    $api_key = crc32($user_id+(int) config('global.SALT')).generateRandomString(36);
    return $api_key;
}

function getMtnNumbers(array $numbers) {
    return preg_grep('/(0|\+98|0098)?((93[0|3|5|6|7|8|9]{1}[0-9]{7})|(90[1-5]{1}[0-9]{7}))/i', $numbers);
}

function getMciNumbers(array $numbers) {
    return preg_grep('/(\+98|0098|0)?((91[0-9]{1}[0-9]{7})|(99[0|1|2|4|9][0-9]{7}))/i', $numbers);
}

function getRightelNumbers(array $numbers) {
    return preg_grep('/(0|\+98|0098)?(92[0-9]{1}[0-9]{7})/i', $numbers);
}

function getTaliaNumbers(array $numbers) {
    return preg_grep('/(0|\+98|0098)?(932[0-9]{7})/i', $numbers);
}

function getSpadanNumbers(array $numbers) {
    return preg_grep('/(0|\+98|0098)?(931[0-9]{7})/i', $numbers);
}

function getTkcNumbers(array $numbers) {
    return preg_grep('/(0|\+98|0098)?(934[0-9]{7})/i', $numbers);
}

function getOtherNumbers(array $numbers) {
    return preg_grep('/(0|\+98|0098)?(93[1|4]{1}[0-9]{7})/i', $numbers);
}

function addVat($amount) {
        return $amount + ($amount * 0.09); // 1000 to 1090
}

function removeVat($amount) {
    return $amount / 1.09; // 1090 to 1000
}
function money_unit() {
    $unit = settings()->get('MONEY_UNIT', $default = null);
    return $unit;
}
function money_unit_code() {
    $unit = settings()->get('MONEY_UNIT_CODE', $default = null);
    return $unit;
}
function effectsUserCredit($type) {
    if(in_array($type, [
        \App\Enums\TransactionEnum::TYPE_SEND_SMS,
        \App\Enums\TransactionEnum::TYPE_CHARGE,
        \App\Enums\TransactionEnum::TYPE_RETURN_MONEY,
        \App\Enums\TransactionEnum::TYPE_INCREASED_BY_ADMIN,
        \App\Enums\TransactionEnum::TYPE_DECREASED_BY_ADMIN,
        \App\Enums\TransactionEnum::TYPE_INCREASED_BY_EMPLOYER,
        \App\Enums\TransactionEnum::TYPE_DECREASED_BY_EMPLOYER,
        \App\Enums\TransactionEnum::TYPE_EMPLOYEE_RETURN_MONEY,
        \App\Enums\TransactionEnum::TYPE_EMPLOYEE_SMS,
        \App\Enums\TransactionEnum::TYPE_EMPLOYEE_INCREASED_BY_EMPLOYER,
        \App\Enums\TransactionEnum::TYPE_EMPLOYEE_DECREASED_BY_EMPLOYER,
        ])
    ) {
        return true;
    }
    return false;
}

function XmlToArray($xml)
{
    $defaults = [
        'return' => 'simplexml',
        'loadEntities' => false,
        'readFile' => true,
        'parseHuge' => false,
    ];
    if(gettype($xml) == 'string') {
        $xml = simplexml_load_string($xml);
    }
    if($xml instanceof SimpleXMLElement)
    {
        $root_element = $xml->getName();
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        return [$root_element => $array];
    }
    return false;
}

function addZeroBeforeNumber(array $array)
{
    $new = [];
    foreach ($array as $item) {
        $new[] = '0'.$item;
    }
    return $new;
}

function make_slug($string) {
    return preg_replace('/\s+/u', '-', trim($string));
}

function make_unslug($string) {
    return ucwords(str_replace('-', ' ', $string));
}

function getJobThrottleDelay($job_attemps) {
    $delay = 0;
    switch ($job_attemps) {
        case 1:
            $delay = 60; break; // 1 Minute
        case 2:
            $delay = 120; break; // 2 Minutes
        case 3:
            $delay = 300; break; // 5 Minutes
        case 4:
            $delay = 600; break; // 10 Minutes
        default:
            $delay = 1800; break;// 30 Minutes
    }
    return $delay;
}

function getJobReturnMoneyDelay($receptors_count) {
    $seconds = ceil($receptors_count / 1000) + 2;
    return $seconds * 2;
}

function settingMapper($type)
{
    $array = [
        'ADDRESS'                => 'آدرس شرکت',
        'EMAIL'                => 'ایمیل شرکت',
        'MONEY_UNIT'                => 'واحد پول',
        'MONEY_UNIT_CODE'           => 'کد واحد پول',
        'SITE_TITLE'       => 'عنوان سایت',
        'SITE_DESCRIPTION' => 'توضیحات سایت',
        'SITE_URL'    => 'آدرس سایت(بدون HTTP)',
        'SITE_URI'    => 'آدرس کامل سایت(همراه با HTTP)',
        'SITE_URI_SSL'    => 'آدرس امن سایت(SSL)',
        'MIN_CHARGE_AMOUNT'    => 'حداقل میزان شارژ اعتبار',
        'PASSWORD_EXPIRE_AFTER'    => 'زمان منقضی شدن رمز عبور(دقیقه)',
        'NOTIFICATION_NUMBER'    => 'شماره خط برای ارسال اطلاعیه',
        'RESET_PASSWORD_KEYWORD'    => 'کلمه کلیدی برای بازگردانی رمز عبور',
        'ASK_ADMIN_SERVICE_SMS'    => 'تعداد پیامک جهت تایید(خدماتی)',
        'ASK_ADMIN_ADVERTISEMENT_SMS'    => 'تعداد پیامک جهت تایید(تبلیغاتی)',
        'SUPPORT_TEL'    => 'تلفن پشتیبانی',
        'FAX'    => 'فکس شرکت',
        'ZIP_CODE'    => 'صندوق پستی',
        'ADD_BLACKLIST'  => 'کلمه کلیدی اضافه به بلک لیست',
        'CANCEL_BLACKLIST'  => 'کلمه کلیدی حذف از بلک لیست',
        'SHARED_SERVICE_LINE_PRICE'  => 'هزینه خط اشتراکی - خدماتی',
        'SHARED_ADVERTISEMENT_LINE_PRICE'  => 'هزینه خط اشتراکی - تبلیغاتی',
        'DEFAULT_SHARED_ADVERTISEMENT_GROUP_ID'  => 'شناسه گروه پیش‌فرض خطوط اشتراکی-تبلیغاتی',
        'SITE_META_DESCRIPTION'  => 'توضیحات تگ meta',
        'SITE_META_KEYWORDS'  => 'کلمات کلیدی meta',
        'SABANOVIN_API_KEY'  => '',
    ];
    return $array[$type];
}

function getMobileOperator($number)
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
        return 'mci'; //default for unknown mobile operators
}

function getPriceOfThisNumber($number, $lang, $sms_operator_id)
{
    $tarrifs = getTariffs(null, $lang, $sms_operator_id);
    return $tarrifs[getMobileOperator($number)];
}
function getUserMode()
{
    return 'user';
}
function isEnvoyerUser()
{
    $domain = request()->getHost();
    return \Cache::get("envoy-{$domain}");
}

function getEnvoyId()
{
    return session()->get('envoy_id');
}

function bankGatewaysIconMapper($bank_name)
{
    $array = [
        'SAMAN' => 'sep',
        'ZARINPAL' => 'zpal',
        'PASARGAD' => 'pep',
    ];
    return $array[$bank_name];
}

if (!function_exists('settings')) {
    function settings() {
        return $settings = app('settings');
    }
}
