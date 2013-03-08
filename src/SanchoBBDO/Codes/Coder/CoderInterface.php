<?php

namespace SanchoBBDO\Codes\Coder;

use Symfony\Component\Config\Definition\ConfigurationInterface;

interface CoderInterface
{
    public function __construct($config = array());
    public function encode($digit);
    public function isValid($code);
    public function parse($code);
    public function getBoundary();
}
