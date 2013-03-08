<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\CodesSource;

class CodesSourceTest extends CodesTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->source = new CodesSource($this->codes);
    }

    public function testImplementssourceInterface()
    {
        $this->assertInstanceOf('\\Exporter\\Source\\SourceIteratorInterface', $this->source);
    }

    public function testCurrentReturnsNormalizedCode()
    {
        $expected = array('code' => $this->codes->current());
        $this->assertEquals($expected, $this->source->current());
    }

    public function testKeyReturnsReturnsCurrentCodeKey()
    {
        $this->assertEquals($this->codes->key(), $this->source->key());
    }

    public function testNextForwardsCodesPointer()
    {
        $code = array('code' => $this->codes->current());
        $this->source->next();
        $this->assertNotEquals($code, $this->source->current());
    }

    public function testRewindResetsCodes()
    {
        $code = array('code' => $this->codes->current());
        next($this->codes);

        $this->source->rewind();
        $this->assertEquals($code, $this->source->current());
    }

    public function testGetFields()
    {
        $this->assertEquals(array('codes'), $this->source->getFields());
    }
}
