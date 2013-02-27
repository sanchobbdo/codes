<?php

namespace SanchoBBDO\Tests\Codes;

use \SanchoBBDO\Codes\Codes;
use \SanchoBBDO\Codes\CodesDumper;

class CodesDumperTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->codes = new Codes(array(
            'secret_key' => 'bombastic',
            'length' => 10
        ));
    }

    public function testDumpsCodes()
    {
        $writer = $this->getMock(
            '\\SanchoBBDO\\Codes\\DumpWriter\\DumpWriterInterface',
            array('write')
        );

        $writer->expects($this->exactly($this->codes->length))
               ->method('write')
               ->with($this->anything());

        $dumper = new CodesDumper($this->codes, $writer);
        $dumper->dump();
    }
}
