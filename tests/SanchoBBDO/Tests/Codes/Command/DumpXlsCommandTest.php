<?php

namespace SanchoBBDO\Tests\Codes\Command;

use SanchoBBDO\Codes\Command\DumpXlsCommand;

class DumpXlsCommandTest extends CommandTestCase
{
    public function createCommand()
    {
        return new DumpXlsCommand('dump');
    }

    public function testGetFileWriterReturnsXlsWriter()
    {
        $input = $this->getMockForAbstractClass('Symfony\\Component\\Console\\Input\\InputInterface');
        $output = $this->getMockForAbstractClass('Symfony\\Component\\Console\\Output\\OutputInterface');
        $this->assertInstanceOf(
            '\\Exporter\\Writer\\XlsWriter',
            $this->command->getFileWriter('file.txt', $input, $output)
        );
    }
}
