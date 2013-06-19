<?php

namespace SanchoBBDO\Codes\Util;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;

class Config
{
    public static function process(ConfigurationInterface $configuration, array $config)
    {
        $processor = new Processor();
        return $processor->processConfiguration($configuration, array($config));
    }
}
