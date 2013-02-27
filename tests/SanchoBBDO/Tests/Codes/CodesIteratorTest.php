<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\Codes;
use SanchoBBDO\Codes\CodesIterator;

class CodesIteratorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->codes = new Codes(array(
            'secret_key' =>  '1461932c2e74b726c795742e1caa8b4a281ea09c',
            'length' => 10
        ));

        $this->iterator = new CodesIterator($this->codes);
    }

    public function testIterator()
    {
        $i = 0;
        foreach ($this->iterator as $key => $value) {
            $this->assertEquals($i, $key);
            $this->assertEquals($this->codes->of($i), $value);
            $i++;
        }

        if (!$i) {
            $this->fail("Didn't iterate");
        }

        $this->assertEquals($this->codes->length - 1, $key);
    }
}
