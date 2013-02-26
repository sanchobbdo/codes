<?php

namespace SanchoBBDO\Tests;

class LuniqTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->luniq = new \SanchoBBDO\Luniq();
    }

    public function testOfReturnsAString()
    {
        $this->assertInternalType('string', $this->luniq->of(100));
    }
}
