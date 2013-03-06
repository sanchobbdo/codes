<?php

namespace SanchoBBDO\Codes;

use SanchoBBDO\Codes\Coder;
use SanchoBBDO\Codes\Codes;

class CodesFactory
{
    public static function build($config = array())
    {
        $coder = new Coder($config['secret_key']);
        $codes = new Codes($coder, $config['offset'], $config['limit']);
        return $codes;
    }
}
