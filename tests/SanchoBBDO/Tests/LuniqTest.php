<?php

namespace SanchoBBDO\Tests;

class LuniqTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->luniq = new \SanchoBBDO\Luniq(array(
            'secretKey' => '1461932c2e74b726c795742e1caa8b4a281ea09c'
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

    /**
     * @dataProvider codesDataProvider
     */
    public function testIsValidValidatesCodes($code, $assert)
    {
        $this->assertEquals($assert, $this->luniq->isValid($code));
    }

    public function codesDataProvider()
    {
        return array(
            array('002s80e8d8', true),
            array('002s652139', false),
            array('00rsd9a978', true),
            array('00rsd9a976', false),
            array('07psb2d7e8', true),
            array('07psb257e8', false),
            array('lfls35d29f', true),
            array('5yc1sb94dc3', false)
        );
    }
}
