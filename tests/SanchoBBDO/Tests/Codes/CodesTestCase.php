<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\Coder;
use SanchoBBDO\Codes\Codes;

class CodesTestCase extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->coder = new Coder('1461932c2e74b726c795742e1caa8b4a281ea09c');
        $this->codes = new Codes($this->coder, 10, 10);
    }
}
