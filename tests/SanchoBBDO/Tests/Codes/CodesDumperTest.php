<?php

namespace SanchoBBDO\Tests\Codes;

use \SanchoBBDO\Codes\Coder;
use \SanchoBBDO\Codes\Codes;
use \SanchoBBDO\Codes\CodesDumper;

class CodesDumperTest extends CodesTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->writer = $this->getMock(
            '\\SanchoBBDO\\Codes\\DumpWriter\\DumpWriterInterface',
            array('open', 'write', 'close')
        );

        $this->dumper = new CodesDumper($this->codes, $this->writer);
    }

    public function testCallsWriterWriteMethod()
    {
        $this->writer->expects($this->exactly($this->codes->getLimit()))
                     ->method('write')
                     ->with($this->anything());

        $this->dumper->dump();
    }

    public function testCallsWriterOpenMethod()
    {
        $this->writer->expects($this->once())
                     ->method('open');

        $this->dumper->dump();
    }

    public function testCallsWriterCloseMethod()
    {
        $this->writer->expects($this->once())
                     ->method('close');

        $this->dumper->dump();
    }
}
