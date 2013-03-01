<?php

namespace SanchoBBDO\Tests\Codes;

use \SanchoBBDO\Codes\Coder;
use \SanchoBBDO\Codes\CodesDumper;

class CodesDumperTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->coder = new Coder(array(
            'secret_key' => 'bombastic',
            'length' => 10
        ));

        $this->writer = $this->getMock(
            '\\SanchoBBDO\\Codes\\DumpWriter\\DumpWriterInterface',
            array('open', 'write', 'close')
        );

        $this->dumper = new CodesDumper($this->coder, $this->writer);
    }

    public function testCallsWriterWriteMethod()
    {
        $this->writer->expects($this->exactly($this->coder->length))
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
