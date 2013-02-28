<?php

namespace SanchoBBDO\Tests\Codes\DumpWriter;

use SanchoBBDO\Codes\DumpWriter\ConsoleDumpWriter;
use Symfony\Component\Console\Output\StreamOutput;

class ConsoleDumpWriterTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->output = new StreamOutput(fopen('php://memory', 'w', false));
        $this->writer = new ConsoleDumpWriter($this->output);
    }

    protected function getOutputContent()
    {
        rewind($this->output->getStream());
        return stream_get_contents($this->output->getStream());
    }

    public function testWritesToConsole()
    {
        $this->writer->write('Hola');
        $this->writer->write('loco');

        $this->assertEquals("Hola\nloco\n", $this->getOutputContent());
    }
}
