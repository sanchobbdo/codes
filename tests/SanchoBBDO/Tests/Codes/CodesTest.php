<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\Coder;

class CodesTest extends CodesTestCase
{
    public function testIterator()
    {
        $i = 0;
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

    public function testCoderGetter()
    {
        $this->assertEquals($this->coder, $this->codes->getCoder());
    }

    public function testCoderSetter()
    {
        $coder = new Coder(array(
            'secret_key' => 'sdfsdfs',
            'length' => 10
        ));

        $this->codes->setCoder($coder);
        $this->assertEquals($coder, $this->codes->getCoder());
    }
}
