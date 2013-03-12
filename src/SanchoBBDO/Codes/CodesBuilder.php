<?php

namespace SanchoBBDO\Codes;

class CodesBuilder
{
    public static function buildCodes($config = array())
    {
        $config = Utils::processConfig(new CodesConfiguration(), $config);

        $class = Utils::arrayGetAndUnsetKey($config['coder'], 'class');
        $coder = new $class($config['coder']);

        return new Codes($coder, $config['offset'], $config['limit']);
    }
}
