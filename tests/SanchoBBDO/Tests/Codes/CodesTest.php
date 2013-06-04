<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\Codes;
use SanchoBBDO\Codes\Coder\Coder;

class CodesTest extends CodesTestCase
{
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

    public function testDefaultLimitIsMaxAvailableCodes()
    {
        $codes = new Codes($this->coder, 10);
        $this->assertEquals($this->coder->getBoundary() - 10, $codes->getLimit());
    }

    public function testConstructorSetsLimit()
    {
        $codes = new Codes($this->coder, 0, 100);
        $this->assertEquals(100, $codes->getLimit());
    }

    /**
     * @expectedException \SanchoBBDO\Codes\Exception\OffBoundaryException
     */
    public function testShouldThrowExceptionIfLimitIsGreaterThanPermitted()
    {
        new Codes($this->coder, 0, $this->coder->getBoundary() + 10);
    }
}
