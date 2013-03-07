<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\Codes;

class CodesFactory
{
    public static function createCodes()
    {
        $config = yaml_parse_file(dirname(__DIR__).'/Codes/Fixture/config.yaml');
        $codes = Codes::from($config);

        return $codes;
    }
}
