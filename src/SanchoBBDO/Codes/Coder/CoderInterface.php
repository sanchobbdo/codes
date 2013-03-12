<?php

/**
 * @author  Camilo Aguilar <camiloaguilar@sanchobbdo.com.co>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/sanchobbdo/codes
 */

namespace SanchoBBDO\Codes\Coder;

interface CoderInterface
{
    public function __construct($config = array());

    /**
     * @param string
     * @return string
     */
    public function encode($digit);

    /**
     * @param string
     * @return bool
     */
    public function isValid($code);

    /**
     * @param string
     * @return array First item is the number corresponding to the code, the
     * second item is the mac.
     */
    public function parse($code);

    /**
     * @return int Top most boundary
     */
    public function getBoundary();
}
