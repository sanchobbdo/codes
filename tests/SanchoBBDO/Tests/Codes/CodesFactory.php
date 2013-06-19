<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\CodesBuilder;
use Symfony\Component\Yaml\Yaml;

class CodesFactory
{
    public static function createCodes()
    {
        $config = Yaml::parse(dirname(__DIR__).'/Codes/Fixture/config.yaml');
        $codes = CodesBuilder::buildCodes($config);

        return $codes;
    }
}
