<?php

namespace App\Models;

use App\User;
use App\Utility\sendMassage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
//    use HasFactory;

    const EXPIRATION_TIME = 2; // minutes

    protected $fillable = [
        'code',
        'user_id',
        'used'
    ];
    public function __construct(array $attributes = [])
    {
        if (! isset($attributes['code'])) {
            $attributes['code'] = $this->generateCode();
        }

        parent::__construct($attributes);
    }
    public function generateCode($codeLength = 4)
    {
        $max = pow(10, $codeLength);
        $min = $max / 10 - 1;
        $code = mt_rand($min, $max);
        return $code;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function isValid()
    {
        return ! $this->isUsed() && ! $this->isExpired();
    }
    public function isUsed()
    {
        return $this->used;
    }
    public function isExpired()
    {
        return $this->created_at->diffInMinutes(Carbon::now()) > static::EXPIRATION_TIME;
    }
    public function sendCode()
    {
        if (! $this->user) {
            throw new \Exception("هیچ کاربری به این رمز پیوست نشده است.");
        }

        if (! $this->code) {
            $this->code = $this->generateCode();
        }

        try {

        } catch (\Exception $ex) {
            return false; //enable to send SMS
        }

        return true;
    }

}
