<?php

namespace SanchoBBDO\Tests\Codes\Util;

use SanchoBBDO\Codes\Util\Base36;

class Base36Test extends \PHPUnit_Framework_TestCase
{
    public function testEncode()
    {
        $this->assertEquals('a', Base36::encode(10));
    }

    public function testDecode()
    {
        $this->assertEquals(10, Base36::decode('a'));
    }
}
