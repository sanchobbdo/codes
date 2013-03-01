<?php

namespace SanchoBBDO\Codes;

use SanchoBBDO\Codes\CodesConfiguration;
use Symfony\Component\Config\Definition\Processor;

class Codes
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

    public function __get($name)
    {
        $snakeCased = Utils::camelToSnake($name);

        if (isset($this->settings[$snakeCased])) {
            return $this->settings[$snakeCased];
        }

        $class = get_class($this);
        trigger_error("Cannot access undefined property {$class}::\${$name}", E_USER_ERROR);
    }

    public function of($digit)
    {
        $index = Utils::base36Encode($digit);
        $index = Utils::zerofill($index, 4);
        return $this->generateFor($index);
    }

    public function isValid($code)
    {
        $index = $this->parseIndex($code);
        return $this->generateFor($index) == $code;
    }

    protected function parseIndex($code)
    {
        return substr($code, 0, 4);
    }

    protected function generateFor($index)
    {
        return $index.substr($this->encrypt($index), 0, 6);
    }

    protected function encrypt($index)
    {
        return sha1($index.$this->secretKey);
    }
}
