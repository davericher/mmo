<?php namespace Irony\Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;

use Validator;


class SessionService {

    protected static $filters = [];

    /**
     * Set a session Variable from Input:: Helper function
     * @param $key
     * @param $default
     * @param $rules
     * @return string
     */
    public function setInput($key, $default,  $rules )
    {
        if (!Session::has($key))
            Session::put($key,$default);

        if (Input::has($key) and Input::get($key) != Session::get($key))
        {
            $val = Validator::make(Input::only([$key]), [$key => $rules]);
            if ($val->passes())
            {
                Session::set($key,Input::get($key));
                $property = self::camelCasetoString($key);
                $attribute = self::filterSessionValue(Input::get($key));
                Session::flash('message',$property.'&nbsp;set to&nbsp;'.$attribute);
            }
        }
        return Session::get($key);
    }

    /**
     * Return a lower case string from a camel case input
     * @param $camelCase
     * @return string
     */
    protected static function camelCasetoString($camelCase)
    {
       return ucwords(strtolower(implode(preg_split('/(?=[A-Z])/',$camelCase),' ')));
    }
    protected static function deSnake($value)
    {
        return str_replace('_',' ',$value);
    }

    /**
     * Basic str_replace filter to fix some formatting of output messages
     * @param $value
     * @return string
     */
    protected static function filterSessionValue($value)
    {
        $value = self::deSnake($value);
        $filters = array_merge([
            'asc'   => lang::get('sessionservice.asc'),
            'desc'  =>  lang::get('sessionservice.desc'),
        ], self::$filters);

        foreach($filters as $search => $replace)
            $value = str_replace($search,$replace,$value);

        return ucfirst($value);
    }
} 