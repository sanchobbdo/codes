<?php

namespace SanchoBBDO\Tests\Codes\Command;

use SanchoBBDO\Codes\Command\DumpCsvCommand;

class DumpCsvCommandTest extends CommandTestCase
{
    public function createCommand()
    {
        return new DumpCsvCommand('dump');
    }

    public function testDelimiterOption()
    {
        $this->assertInputOption('delimiter', 'd', true, true);
    }

    public function testEnclosureOption()
    {
        $this->assertInputOption('enclosure', 'e', true, true);
    }

    public function testEscapeOption()
    {
        $this->assertInputOption('escape', 's', true, true);
    }

    public function testGetFileWriterReturnsCsvWriter()

    {
        $input = $this->getMockForAbstractClass('Symfony\\Component\\Console\\Input\\InputInterface');
        $output = $this->getMockForAbstractClass('Symfony\\Component\\Console\\Output\\OutputInterface');
        $this->assertInstanceOf(
            '\\Exporter\\Writer\\CsvWriter',
            $this->command->getFileWriter('file.txt', $input, $output)
        );
    }
}
