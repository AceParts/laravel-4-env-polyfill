<?php

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);
        
        if ($value === false) {
            $default = call_user_func(function ($default) { return $default instanceof Closure ? $default() : $default; }, $default);
            return $default;
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }
        
        $quoted = (function ($value, $char = '"') {
            return (bool) (preg_match('/^' . $char . '/', $str) && preg_match('/' . $char . '$/', $str));
        });
        
        if($quoted) {
            return  trim($value, '"');
        }
        
        return $value;
    }
}