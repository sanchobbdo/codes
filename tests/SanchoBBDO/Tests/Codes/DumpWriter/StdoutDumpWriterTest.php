<?php

namespace SanchoBBDO\Tests\Codes\DumpWriter;

use SanchoBBDO\Codes\DumpWriter\StdoutDumpWriter;

class StdoutDumpWriterTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->writer = new StdoutDumpWriter();
    }

    public function testWritesToStdout()
    {
        ob_start();
        $this->writer->write('Hola');
        $this->writer->write('loco');
        $stdout = ob_get_contents();
        ob_end_clean();

        $this->assertEquals("Hola\nloco\n", $stdout);
    }
}
