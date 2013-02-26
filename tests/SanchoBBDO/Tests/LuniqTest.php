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

    /**
     * @dataProvider ofReturnsCodeForIndex
     */
    public function testOfReturnsCodeForIndex($index, $code)
    {
        $this->assertEquals($code, $this->luniq->of($index));
    }


    public function ofReturnsCodeForIndex()
    {
        return array(
            array(123456, '2n9c00d7a3'),
            array(900000, 'jag0bf80a5'),
            array(16000000, '9ixogf2ef8a'),
            array(20, '000k05ce1b'),
        );
    }

    /**
     * @dataProvider isValidVerifiesCodesProvider
     */
    public function testIsValidVerifiesCodes($code, $assert)
    {
        $this->assertEquals($assert, $this->luniq->isValid($code));
    }

    public function  isValidVerifiesCodesProvider()
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
