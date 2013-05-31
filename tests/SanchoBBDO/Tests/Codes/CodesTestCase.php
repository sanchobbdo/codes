<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Tests\Codes\Coder\MockCoder;
use SanchoBBDO\Codes\Codes;

class CodesTestCase extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->coder = new MockCoder();
        $this->codes = new Codes($this->coder, 10, 10);
    }
}
