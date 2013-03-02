<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\Codes;
use SanchoBBDO\Codes\Coder;

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

        $this->assertEquals($this->coder->length - 1, $key);
    }

    public function testCoderSetterAndGetter()
    {
        $coder = new Coder(array(
            'secret_key' => 'sdfsdfs',
            'length' => 10
        ));

        $this->codes->setCoder($coder);
        $this->assertEquals($coder, $this->codes->getCoder());
    }

    public function testOffsetSetterandGetter()
    {
        $this->codes->setOffset(11);
        $this->assertEquals(11, $this->codes->getOffset());
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
}
