<?php

namespace SanchoBBDO\Codes\Util;

class Hash
{
    public static function pull(&$array, $key)
    {
        $value = $array[$key];
        unset($array[$key]);
        return $value;
    }
}
