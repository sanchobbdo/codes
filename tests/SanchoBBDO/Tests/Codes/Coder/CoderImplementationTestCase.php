<?php

namespace SanchoBBDO\Tests\Codes\Coder;

abstract class CoderImplementationTestCase extends \PHPUnit_Framework_TestCase
{
    protected $coder;

    abstract protected function getCoder();

    public function setUp()
    {
        $this->coder = $this->getCoder();
    }

    public function testImplementsCoderInterface()
    {
        $this->assertInstanceOf(
            'SanchoBBDO\\Codes\\Coder\\CoderInterface',
            $this->coder
        );
    }

    /**
     * @dataProvider digitsProvider
     */
    public function testEncodeReturnsString($digit)
    {
        $this->assertInternalType('string', $this->coder->encode($digit));
    }

    /**
     * @dataProvider validCodesProvider
     */
    public function testIsValidReturnsTrueForGeneratedCodes($validCode)
    {
        $this->assertTrue($this->coder->isValid($validCode));
    }

    /**
     * @dataProvider invalidCodesProvider
     */
    public function testIsValidReturnsFalseForInvalidCodes($invalidCode)
    {
        $this->assertFalse($this->coder->isValid($invalidCode));
    }

    /**
     * @dataProvider validCodesProvider
     */
    public function testParseReturnsAnArrayContainingTheDigitAndMac($validCode, $digit)
    {
        list($parsedDigit, $parsedMac) = $this->coder->parse($validCode);

        $this->assertEquals($digit, $parsedDigit);
        $this->assertNotEmpty($parsedMac);
    }

    public function testGetBoundaryReturnsAUnsignedInt()
    {
        $boundary = $this->coder->getBoundary();
        $this->assertInternalType('int', $boundary);
        $this->assertGreaterThan(0, $boundary);
    }

    public function digitsProvider()
    {
        $data = array();
        foreach (range(0, 10) as $digit) {
            $data[] = array($digit);
        }

        return $data;
    }

    public function validCodesProvider()
    {
        $data = array();
        foreach (range(0, 10) as $digit) {
            $data[] = array($this->getCoder()->encode($digit), $digit);
        }

        return $data;
    }

    public function invalidCodesProvider()
    {
        return array(
            array('invalid'),
            array('invalid2'),
            array('superinvalid')
        );
    }
}
