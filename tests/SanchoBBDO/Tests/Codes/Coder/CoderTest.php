<?php

namespace SanchoBBDO\Tests\Codes\Coder;

use SanchoBBDO\Codes\Coder\Coder;

class CoderTest extends CoderImplementationTestCase
{
    protected $secretKey = '1461932c2e74b726c795742e1caa8b4a281ea09c';
    protected $macLength = 6;
    protected $keyLength = 4;
    protected $algo = 'sha1';

    public function getCoder()
    {
        return new Coder(array(
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

    public function testAlgoGetter()
    {
        $this->assertEquals($this->algo, $this->coder->getAlgo());
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

    /**
     * @expectedException \SanchoBBDO\Codes\Exception\OffBoundaryException
     */
    public function testEncodeThrowsExceptionIfOffBoundaryDigitIsPassed()
    {
        $this->coder->encode($this->coder->getBoundary() + 1);
    }
}
