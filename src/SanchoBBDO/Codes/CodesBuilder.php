<?php

/**
 * @author  Camilo Aguilar <camiloaguilar@sanchobbdo.com.co>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/sanchobbdo/codes
 */

namespace SanchoBBDO\Codes;

use SanchoBBDO\Codes\Util\Hash;
use SanchoBBDO\Codes\Util\Config;

class CodesBuilder
{
    /**
     * @return Codes
     */
    public static function buildCodes($config = array())
    {
        $config = Config::process(new CodesConfiguration(), $config);

        $class = Hash::pull($config['coder'], 'class');
        $coder = new $class($config['coder']);

        return new Codes($coder, $config['offset'], $config['limit']);
    }
}
