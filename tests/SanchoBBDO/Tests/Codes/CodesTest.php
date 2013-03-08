<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\Codes;
use SanchoBBDO\Codes\Coder\Coder;

class CodesTest extends CodesTestCase
{
    public function testFromGeneratesACodesInstanceFromConfig()
    {
        $config = array(
            'offset' => 100,
            'limit' => 2000,
            'coder' => array(
                'secret_key' => 'secret-key'
            )
        );

        $codes = Codes::from($config);
        $this->assertInstanceOf('\\SanchoBBDO\\Codes\\Codes', $codes);
        $this->assertEquals($config['offset'], $codes->getOffset());
        $this->assertEquals($config['limit'], $codes->getLimit());
        $this->assertEquals($config['coder']['secret_key'], $codes->getCoder()->getSecretKey());
    }

    public function testIterator()
    {
        $i = $this->codes->getOffset();
        foreach ($this->codes as $key => $value) {
            $this->assertEquals($i, $key);
            $this->assertEquals($this->coder->encode($i), $value);
            $i++;
        }

        if (!$i) {
            $this->fail("Didn't iterate");
        }

        $this->assertEquals($this->codes->getLimit() + $this->codes->getOffset() - 1, $key);
    }

    public function testCoderGetter()
    {
        $this->assertEquals($this->coder, $this->codes->getCoder());
    }

    public function testOffsetGetter()
    {
        $this->assertEquals(10, $this->codes->getOffset());
    }

    public function testDefaultOffsetIs0()
    {
        $codes = new Codes($this->coder);
        $this->assertEquals(0, $codes->getOffset());
    }

    public function testConstructorSetsOffset()
    {
        $codes = new Codes($this->coder, 2);
        $this->assertEquals(2, $codes->getOffset());
    }

    public function testLimitGetter()
    {
        $this->assertEquals(10, $this->codes->getLimit());
    }

    public function testDefaultLimitIsMaxAvailableCodes()
    {
        $codes = new Codes($this->coder, 10);
        $this->assertEquals($this->coder->getBoundary() - 10, $codes->getLimit());
    }

    /**
     * @expectedException \SanchoBBDO\Codes\Exception\OffBoundaryException
     */
    public function testShouldThrowExceptionIfLimitIsGreaterThanPermitted()
    {
        new Codes($this->coder, 0, $this->coder->getBoundary() + 10);
    }
}
