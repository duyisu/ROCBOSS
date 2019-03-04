<?php

if (!function_exists('app')) {
    /**
     * Get App instance
     *
     * @return mixed
     */
    function app()
    {
        return Flight::app();
    }
}

if (!function_exists('env')) {
    /**
     * Get ENV variable
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    function env($name, $default = null)
    {
        return getenv($name) ? : $default;
    }
}

if (!function_exists('guid')) {
    /**
    * 获取GUID
    * @method getGuid
    * @param  string  $rand [description]
    * @return string
    */
    function guid($rand = 'batio')
    {
        $charId = strtolower(md5(uniqid(mt_rand().$rand, true)));

        $hyphen = chr(45);// "-"
        $uuid = substr($charId, 0, 8).$hyphen
                .substr($charId, 8, 4).$hyphen
                .substr($charId, 12, 4).$hyphen
                .substr($charId, 16, 4).$hyphen
                .substr($charId, 20, 12);

        return $uuid;
    }
}

if (!function_exists('getAllHeader')) {
    /**
     * Get headers
     * @method getAllHeader
     * @return array
     */
    function getAllHeader()
    {
        if (!function_exists('getallheaders')) {
            $headers = [];

            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }

            return array_change_key_case($headers, CASE_LOWER);
        } else {
            return array_change_key_case(getallheaders(), CASE_LOWER);
        }
    }
}

if (!function_exists('route')) {
    /**
     * Route
     * @method route
     * @param  mixed  $pattern
     * @param  mixed  $callback
     * @return Object
     */
    function route($pattern, $callback)
    {
        Flight::route($pattern, $callback);

        return Middleware::getInstance()->setCallback($callback);
    }
}

if (!function_exists('formatTime')) {
    /**
     * 格式化时间
     *
     * @param integer $time
     * @return void
     */
    function formatTime($time)
    {
        $rtime = date("m-d H:i", $time);
        $htime = date("H:i", $time);
        $time = time() - $time;
        if ($time < 60) {
            $str = '刚刚';
        } elseif ($time < 60 * 60) {
            $min = floor($time / 60);
            $str = $min.'分钟前';
        } elseif ($time < 60 * 60 * 24) {
            $h = floor($time / (60*60));
            $str = $h.'小时前';
        } elseif ($time < 60 * 60 * 24 * 3) {
            $d = floor($time / (60 * 60 * 24));
            if ($d == 1) {
                $str = '昨天 '.$htime;
            } else {
                $str = '前天 '.$htime;
            }
        } else {
            $str = $rtime;
        }
        return $str;
    }
}
