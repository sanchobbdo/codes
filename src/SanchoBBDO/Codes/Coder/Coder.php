<?php

namespace SanchoBBDO\Codes\Coder;

use SanchoBBDO\Codes\Exception\OffBoundaryException;
use SanchoBBDO\Codes\Utils;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor;

class Coder implements CoderInterface
{
    private $secretKey;

    public function __construct($config = array())
    {
        $config = Utils::processConfig(new CoderConfiguration, $config);

        $this->secretKey = $config['secret_key'];
    }

    public function encode($digit)
    {
        if ($digit > $this->getBoundary()) {
            throw new OffBoundaryException("Digit {$digit} is bigger than permitted boundary {$this->getBoundary()}");
        }

        $key = Utils::base36Encode($digit);
        $key = Utils::zerofill($key, 4);

        return $key.substr($this->encrypt($key), 0, 6);
    }

    public function isValid($code)
    {
        list($digit, $mac) = $this->parse($code);
        return $this->encode($digit) == $code;
    }

    public function parse($code)
    {
        return array(
            Utils::base36Decode(substr($code, 0, 4)),
            substr($code, 4)
        );
    }

    public function getBoundary()
    {
        return pow(36, 4);
    }

    protected function encrypt($key)
    {
        return sha1($key.$this->getSecretKey());
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }
}
