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
}
