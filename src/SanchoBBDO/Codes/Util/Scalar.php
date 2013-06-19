<?php

namespace SanchoBBDO\Codes\Util;

class Scalar
{
    public static function zerofill($scalar, $length)
    {
        return str_pad($scalar, $length, '0', STR_PAD_LEFT);
    }
}
