<?php

namespace SanchoBBDO\Tests\Codes\Coder;

use SanchoBBDO\Codes\Coder\CoderInterface;
use SanchoBBDO\Codes\Exception\OffBoundaryException;

class MockCoder implements CoderInterface
{
    public function __construct($config = array())
    {

    }

    public function encode($digit)
    {
        if ($digit > $this->getBoundary()) {
            throw new OffBoundaryException("Digit {$digit} is bigger than permitted boundary {$this->getBoundary()}");
        }

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
