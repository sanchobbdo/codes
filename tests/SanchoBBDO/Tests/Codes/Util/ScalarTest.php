<?php

namespace SanchoBBDO\Tests\Codes\Util;

use SanchoBBDO\Codes\Util\Scalar;

class ScalarTest extends \PHPUnit_Framework_TestCase
{
    public function testZerofill()
    {
        $this->assertEquals('0000000001', Scalar::zerofill(1, 10));
    }
}
