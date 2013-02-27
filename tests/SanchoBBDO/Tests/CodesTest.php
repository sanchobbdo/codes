<?php

namespace SanchoBBDO\Tests;

class CodesTest extends \PHPUnit_Framework_TestCase
{
    protected $secretKey = '1461932c2e74b726c795742e1caa8b4a281ea09c';

    public function setUp()
    {
        $this->codes = new \SanchoBBDO\Codes(array(
            'secret_key' => $this->secretKey,
            'length' => 10
        ));
    }

    public function testCanAccessSettingsAsProperties()
    {
        $this->assertEquals(10, $this->codes->length);
    }

    public function testTransformsSettingsKeysFromSnakeCaseToCamelCase()
    {
        $this->assertEquals($this->secretKey, $this->codes->secretKey);
    }

    public function testAsIterator()
    {
        $i = 0;
        foreach ($this->codes as $key => $value) {
            $this->assertEquals($i, $key);
            $this->assertEquals($this->codes->of($i), $value);
            $i++;
        }

        if (!$i) {
            $this->fail("Didn't iterate");
        }

        $this->assertEquals($this->codes->length - 1, $key);
    }

    public function testAsArrayAccess()
    {
        for ($i = 0; $i < $this->codes->length; $i++) {
            $this->assertTrue(isset($this->codes[$i]));
            $this->assertEquals($this->codes->of($i), $this->codes[$i]);
        }

        $this->assertFalse(isset($this->codes[$this->codes->length]));
    }

    public function testAsCountable()
    {
        $this->assertEquals(10, count($this->codes));
    }

    public function testConstructorSetsConfig()
    {
        $codes = new \SanchoBBDO\Codes(array(
            'secret_key' => 'some secret key',
            'length' => 1000
        ));

        $this->assertEquals('some secret key', $codes->secretKey);
        $this->assertEquals(1000, $codes->length);
    }

    /**
     * @dataProvider ofReturnsCodeForIndex
     */
    public function testOfReturnsCodeForIndex($index, $code)
    {
        $this->assertEquals($code, $this->codes->of($index));
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
        $this->assertEquals($assert, $this->codes->isValid($code));
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
