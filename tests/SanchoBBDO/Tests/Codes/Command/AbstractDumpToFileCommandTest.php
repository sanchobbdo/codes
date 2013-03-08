<?php

namespace SanchoBBDO\Tests\Codes\Command;

class AbstractDumpToFileCommandTest extends CommandTestCase
{
    public function createCommand()
    {
        return $this->getMockForAbstractClass('\\SanchoBBDO\\Codes\\Command\\AbstractDumpToFileCommand', array('dump'));
    }

    public function testFileArgument()
    {
        $this->assertInputArgument('file', true);
    }

    public function testCallsGetFileWriter()
    {
        $writer = $this->getMock('\\Exporter\\Writer\\WriterInterface');
        $this->command
                ->expects($this->once())
                ->method('getFileWriter')
                ->with(
                    $this->equalTo('file.txt'),
                    $this->isInstanceOf('Symfony\\Component\\Console\\Input\\InputInterface'),
                    $this->isInstanceOf('Symfony\\Component\\Console\\Output\\OutputInterface')
                )
                ->will($this->returnValue($writer));
        $this->executeDefaultCommnad(array('file' => 'file.txt'));
    }
}
