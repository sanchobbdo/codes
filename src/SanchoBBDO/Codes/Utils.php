<?php

namespace SanchoBBDO\Codes;

class Utils
{
    static public function camelToSnake($camel)
    {
        return preg_replace_callback(
            '/[A-Z]/',
            create_function('$match', 'return "_" . strtolower($match[0]);'),
            $camel
        );
    }

    static public function base36Encode($digit)
    {
        return base_convert($digit, 10, 36);
    }

    static public function zerofill($str, $length)
    {
        return str_pad($str, $length, '0', STR_PAD_LEFT);
    }
}
