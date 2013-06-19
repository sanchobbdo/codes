<?php

namespace SanchoBBDO\Tests\Codes\Util;

use SanchoBBDO\Codes\Util\Hash;

class HashTest extends \PHPUnit_Framework_TestCase
{
    public function testPull()
    {
        $array = array('one' => 1, 'two' => 2);
        $this->assertEquals(1, Hash::pull($array, 'one'));
        $this->assertArrayNotHasKey('one', $array);
    }
}
