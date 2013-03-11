<?php

namespace SanchoBBDO\Codes;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;

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

    static public function base36Decode($base36)
    {
        return base_convert($base36, 36, 10);
    }

    static public function zerofill($str, $length)
    {
        return str_pad($str, $length, '0', STR_PAD_LEFT);
    }

    static public function arrayGetAndUnsetKey(&$array, $key)
    {
        $return = $array[$key];
        unset($array[$key]);
        return $return;
    }

    static public function processConfig(ConfigurationInterface $configuration, array $config)
    {
        $processor = new Processor();
        return $processor->processConfiguration($configuration, array($config));
    }
}
