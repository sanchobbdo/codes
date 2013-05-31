<?php

namespace SanchoBBDO\Tests\Codes\Coder;

use SanchoBBDO\Codes\Coder\CoderInterface;

class MockCoder implements CoderInterface
{
    public function __construct($config = array())
    {

    }

    public function encode($digit)
    {
        return "abc{$digit}";
    }

    public function isValid($code)
    {
        return substr($code, 0, 3) == 'abc';
    }

    public function parse($code)
    {
        return array(
            substr($code, 3),
            substr($code, 0, 3)
        );
    }

    public function getBoundary()
    {
        return 10000;
    }
}
