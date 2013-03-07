<?php

namespace SanchoBBDO\Codes\Coder;

use Symfony\Component\Config\Definition\ConfigurationInterface;

interface CoderInterface extends ConfigurationInterface
{
    public function __construct($config = array());
    public function encode($digit);
    public function isValid($code);
}
