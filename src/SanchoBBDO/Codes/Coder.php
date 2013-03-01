<?php

namespace SanchoBBDO\Codes;

use SanchoBBDO\Codes\CodesConfiguration;
use Symfony\Component\Config\Definition\Processor;

class Coder
{
    protected $setings;

    public function __construct($config)
    {
        $processor = new Processor();
        $this->settings = $processor->processConfiguration(
            new CodesConfiguration,
            array($config)
        );
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
        return sha1($key.$this->secretKey);
    }

    public function __get($name)
    {
        $snakeCased = Utils::camelToSnake($name);

        if (isset($this->settings[$snakeCased])) {
            return $this->settings[$snakeCased];
        }

        $class = get_class($this);
        trigger_error("Cannot access undefined property {$class}::\${$name}", E_USER_ERROR);
    }
}
