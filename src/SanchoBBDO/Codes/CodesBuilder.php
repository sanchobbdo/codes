<?php

/**
 * @author  Camilo Aguilar <camiloaguilar@sanchobbdo.com.co>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/sanchobbdo/codes
 */

namespace SanchoBBDO\Codes;

class CodesBuilder
{
    /**
     * @return Codes
     */
    public static function buildCodes($config = array())
    {
        $config = Utils::processConfig(new CodesConfiguration(), $config);

        $class = Utils::arrayGetAndUnsetKey($config['coder'], 'class');
        $coder = new $class($config['coder']);

        return new Codes($coder, $config['offset'], $config['limit']);
    }
}
