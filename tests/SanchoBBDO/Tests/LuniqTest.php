<?php

namespace SanchoBBDO\Tests;

class LuniqTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->luniq = new \SanchoBBDO\Luniq(array(
            'secretKey' => 'my secret key'
        ));
    }

    public function testConstructorSetsConfig()
    {
        $luniq = new \SanchoBBDO\Luniq(array(
            'secretKey' => 'some secret key',
            'length' => 1000
        ));

        $this->assertEquals('some secret key', $luniq->getSecretKey());
        $this->assertEquals(1000, $luniq->getLength());
    }

    public function testOfReturnsAString()
    {
        $this->assertInternalType('string', $this->luniq->of(100));
    }
}
