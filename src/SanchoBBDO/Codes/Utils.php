<?php

/**
 * @author  Camilo Aguilar <camiloaguilar@sanchobbdo.com.co>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/sanchobbdo/codes
 */

namespace SanchoBBDO\Codes;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;

class Utils
{
    /**
     * @param string
     * @return string
     */
    static public function camelToSnake($camel)
    {
        return preg_replace_callback(
            '/[A-Z]/',
            create_function('$match', 'return "_" . strtolower($match[0]);'),
            $camel
        );
    }

    /**
     * @param int
     * @return strign
     */
    static public function base36Encode($digit)
    {
        return base_convert($digit, 10, 36);
    }

    /**
     * @param string
     * @return int
     */
    static public function base36Decode($base36)
    {
        return base_convert($base36, 36, 10);
    }

    /**
     * @param string
     * @param int
     * @return string
     */
    static public function zerofill($str, $length)
    {
        return str_pad($str, $length, '0', STR_PAD_LEFT);
    }

    /**
     * @param array
     * @param string
     */
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
