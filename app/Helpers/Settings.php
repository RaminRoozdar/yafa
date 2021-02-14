<?php

namespace App\Helpers;
use Cache;

class Settings {

     public $envoy;
     public $table;

     public function __construct()
     {
        if($this->envoy = isEnvoyerUser()) {
            $this->table = 'envoy_settings';
        } else {
            $this->table = 'settings';
        }
     }

     public function set($key, $value)
     {
        if($this->envoy) {
            $cache_key = $this->envoy->id.'_SETTINGS_'.$key;
            $item = app('db')->table($this->table)->where('envoy_id', $this->envoy->id)->first();
        } else {
            $cache_key = 'SETTINGS_'.$key;
            $item = app('db')->table($this->table)->whereKey($key)->first();
        }
        Cache::forget($cache_key);
        if($this->envoy) {
            if($item)
                return app('db')->table($this->table)->update([ strtolower($key) =>$value]);
        } else {
            if($item)
                return app('db')->table('settings')->whereKey($key)->update(['value'=>$value]);
            return app('db')->table('settings')->insert(['key'=>$key, 'value'=>$value]);
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key, $only_main_site = false)
    {
        if( ! $only_main_site && $this->envoy) {
            $key = strtolower($key);
            $envoy_id = $this->envoy->id;
            return Cache::remember($envoy_id.'_SETTINGS_'.$key, 60*72, function() use ($key, $envoy_id) {
                $exists = app('db')->table('envoy_settings')->where('envoy_id', $envoy_id)->select($key)->first();
                if($exists)
                    return $exists->{$key};
            });
        }
        return Cache::remember('SETTINGS_'.$key, 60*72, function() use ($key) {
            $exists = app('db')->table('settings')->whereKey($key)->first();
            if($exists)
                return $exists->value;
        });
    }

    /**
     * @param $key
     * @param $value
     * @return boolean
     */
    public function has($key, $value = null)
    {
        if($value)
            return $this->get($key) === $value;

        if($this->envoy) {
            $key = strtolower($key);
            $envoy_id = $this->envoy->id;
            return app('db')->table('envoy_settings')->where('envoy_id', $envoy_id)->whereNotNull($key)->exists();
        }
        return app('db')->table('settings')->whereKey($key)->exists();
    }
}
