<?php

namespace SanchoBBDO\Tests;

use SanchoBBDO\Codes\Coder;

class CoderTest extends \PHPUnit_Framework_TestCase
{
    protected $secretKey = '1461932c2e74b726c795742e1caa8b4a281ea09c';

    public function setUp()
    {
        $this->coder = new Coder(array(
            'secret_key' => $this->secretKey,
            'length' => 10
        ));
    }

    public function testCanAccessSettingsAsProperties()
    {
        $this->assertEquals(10, $this->coder->length);
    }

    public function testTransformsSettingsKeysFromSnakeCaseToCamelCase()
    {
        $this->assertEquals($this->secretKey, $this->coder->secretKey);
    }

    public function testConstructorSetsConfig()
    {
        $coder = new Coder(array(
            'secret_key' => 'some secret key',
            'length' => 1000
        ));

        $this->assertEquals('some secret key', $coder->secretKey);
        $this->assertEquals(1000, $coder->length);
    }

    public function testParseReturnsCodesDigitAndMac()
    {
        list($digit, $mac) = $this->coder->parse('0001abcdef');
        $this->assertEquals(1, $digit);
        $this->assertEquals('abcdef', $mac);
    }
    /**
     * @dataProvider digitsAndCodesProvider
     */
    public function testEncode($digit, $code)
    {
        $this->assertEquals($code, $this->coder->encode($digit));
    }

    public function digitsAndCodesProvider()
    {
        return array(
            array(123456, '2n9c00d7a3'),
            array(900000, 'jag0bf80a5'),
            array(16000000, '9ixogf2ef8a'),
            array(20, '000k05ce1b'),
        );
    }

    /**
     * @dataProvider codesAndValidityProvider
     */
    public function testIsValid($code, $assert)
    {
        $this->assertEquals($assert, $this->coder->isValid($code));
    }

    public function codesAndValidityProvider()
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
