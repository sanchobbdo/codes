<?php

namespace SanchoBBDO\Codes\Coder;

use Assert\Assertion;
use SanchoBBDO\Codes\Utils;
use Symfony\Component\Config\Definition\Processor;

class Coder implements CoderInterface
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->setSecretKey($secretKey);
    }

    public function encode($digit)
    {
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

    protected function encrypt($key)
    {
        return sha1($key.$this->getSecretKey());
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function setSecretKey($secretKey) {
        Assertion::notBlank($secretKey, "Secret key can't be empty");

        $this->secretKey = $secretKey;
    }
}
