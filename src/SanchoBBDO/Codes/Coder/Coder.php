<?php

/**
 * @author  Camilo Aguilar <camiloaguilar@sanchobbdo.com.co>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/sanchobbdo/codes
 */

namespace SanchoBBDO\Codes\Coder;

use SanchoBBDO\Codes\Exception\OffBoundaryException;
use SanchoBBDO\Codes\Utils;

class Coder implements CoderInterface
{
    private $secretKey;
    private $macLength;
    private $keyLength;
    private $algo;

    public function __construct($config = array())
    {
        $this->init($config);
    }

    protected function init($config)
    {
        $config = Utils::processConfig(new CoderConfiguration, $config);

        $this->setSecretKey($config['secret_key']);
        $this->setMacLength($config['mac_length']);
        $this->setKeyLength($config['key_length']);
        $this->setAlgo($config['algo']);
    }

    public function encode($digit)
    {
        if ($digit > $this->getBoundary()) {
            throw new OffBoundaryException("Digit {$digit} is bigger than permitted boundary {$this->getBoundary()}");
        }

        $key = $this->digitToKey($digit);
        $mac = $this->encrypt($key);

        return $this->composeCode($key, $mac);
    }

    public function isValid($code)
    {
        list($digit) = $this->parse($code);

        return $this->encode($digit) == $code;
    }

    public function parse($code)
    {
        list($key, $mac) = $this->splitCode($code);

        return array($this->keyToDigit($key), $mac);
    }

    public function getBoundary()
    {
        return pow(36, $this->getKeyLength());
    }

    /**
     * @param int
     * @return string
     */
    protected function digitToKey($digit)
    {
        return Utils::base36Encode($digit);
    }

    /**
     * @param string
     * @return int
     */
    protected function keyToDigit($key)
    {
        return Utils::base36Decode($key);
    }

    /**
     * @param string
     * @return array First item is the key, second item is the mac
     */
    protected function splitCode($code)
    {
        return array(
            substr($code, 0, $this->getKeyLength()),
            substr($code, $this->getKeyLength())
        );
    }

    /**
     * @param string
     * @param string
     * @return string Concatenated key and mac
     */
    protected function composeCode($key, $mac)
    {
        return Utils::zerofill($key, $this->getKeyLength()) .
               substr($mac, 0, $this->getMacLength());
    }

    /**
     * @param string
     * @return string
     */
    protected function encrypt($key)
    {
        return hash_hmac($this->getAlgo(), $key, $this->getSecretKey());
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @return string
     */
    public function getMacLength()
    {
        return $this->macLength;
    }

    /**
     * @return string
     */
    public function getKeyLength()
    {
        return $this->keyLength;
    }

    /**
     * @return string
     */
    public function getAlgo()
    {
        return $this->algo;
    }

    /**
     * @param string
     */
    protected function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @param string
     */
    protected function setMacLength($macLength)
    {
        $this->macLength = $macLength;
    }

    /**
     * @param string
     */
    protected function setKeyLength($keyLength)
    {
        $this->keyLength = $keyLength;
    }

    /**
     * @param string
     */
    protected function setAlgo($algo)
    {
        $this->algo = $algo;
    }
}
