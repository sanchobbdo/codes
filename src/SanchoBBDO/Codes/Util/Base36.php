<?php

namespace SanchoBBDO\Codes\Util;

class Base36
{
    public static function encode($digit)
    {
        return base_convert($digit, 10, 36);
    }

    public static function decode($base36)
    {
        return base_convert($base36, 36, 10);
    }
}
