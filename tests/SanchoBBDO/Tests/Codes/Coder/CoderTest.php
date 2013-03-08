<?php

namespace SanchoBBDO\Tests\Coder;

use SanchoBBDO\Codes\Coder\Coder;

class CoderTest extends \PHPUnit_Framework_TestCase
{
    protected $secretKey = '1461932c2e74b726c795742e1caa8b4a281ea09c';
    protected $macLength = 6;
    protected $keyLength = 4;

    public function setUp()
    {
        $this->coder = new Coder(array(
            'secret_key' => $this->secretKey,
            'mac_length' => $this->macLength,
            'key_length' => $this->keyLength,
        ));
    }

    public function tetsSecretKeyGetter()
    {
        $this->assertEquals($this->secretKey, $this->coder->getSecretKey());
    }

    public function testMacLengthGetter()
    {
        $this->assertEquals($this->macLength, $this->coder->getMacLength());
    }

    public function testKeyLengthGetter()
    {
        $this->assertEquals($this->keyLength, $this->coder->getKeyLength());
    }

    public function testParseReturnsCodesDigitAndMac()
    {
        list($digit, $mac) = $this->coder->parse('0001abcdef');
        $this->assertEquals(1, $digit);
        $this->assertEquals('abcdef', $mac);
    }

    public function testGetBoundary()
    {
        $this->assertEquals(1679616, $this->coder->getBoundary());
    }

    public function testEncodeAndValidate()
    {
        for ($i = 100; $i < 120; $i++) {
            $code = $this->coder->encode($i);
            $this->assertNotEmpty($code);
            $this->assertEquals($this->macLength + $this->keyLength, strlen($code));
            $this->assertTrue($this->coder->isValid($code));
        }
    }

    public function testIsValidRejectInvalidCodes()
    {
        for ($i = 0; $i < 20; $i++) {
            $code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $this->macLength + $this->keyLength);
            $this->assertFalse($this->coder->isValid($code));
        }
    }

    /**
     * @expectedException \SanchoBBDO\Codes\Exception\OffBoundaryException
     */
    public function testEncodeThrowsExceptionIfOffBoundaryDigitIsPassed()
    {
        $this->coder->encode($this->coder->getBoundary() + 10);
    }
}
