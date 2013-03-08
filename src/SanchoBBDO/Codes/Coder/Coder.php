<?php

namespace SanchoBBDO\Codes\Coder;

use SanchoBBDO\Codes\Exception\OffBoundaryException;
use SanchoBBDO\Codes\Utils;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor;

class Coder implements CoderInterface
{
    private $secretKey;
    private $macLength;

    public function __construct($config = array())
    {
        $config = Utils::processConfig(new CoderConfiguration, $config);
        $this->setSecretKey($config['secret_key']);
        $this->setMacLength($config['mac_length']);
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
        list($digit, $mac) = $this->parse($code);

        return $this->encode($digit) == $code;
    }

    public function parse($code)
    {
        list($key, $mac) = $this->splitCode($code);

        return array($this->keyToDigit($key), $mac);
    }

    public function getBoundary()
    {
        return pow(36, 4);
    }

    protected function digitToKey($digit)
    {
        return Utils::zerofill(Utils::base36Encode($digit), 4);
    }

    protected function keyToDigit($key)
    {
        return Utils::base36Decode($key);
    }

    protected function splitCode($code)
    {
        return array(substr($code, 0, 4), substr($code, 4));
    }

    protected function composeCode($key, $mac)
    {
        return $key.substr($mac, 0, $this->getMacLength());
    }

    protected function encrypt($key)
    {
        return sha1($key.$this->getSecretKey());
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function getMacLength()
    {
        return $this->macLength;
    }

    protected function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    protected function setMacLength($macLength)
    {
        $this->macLength = $macLength;
    }
}
