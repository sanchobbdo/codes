<?php

namespace SanchoBBDO\Tests\Codes\Command;

use SanchoBBDO\Codes\Command\DumpCommand;

class DumpCommandTest extends CommandTestCase
{
    protected function createCommand()
    {
        return new DumpCommand;
    }

    public function testGetDumpWriterReturnsAConsoleDumpWriter()
    {
        $this->executeDefaultCommnad();
        $this->assertInstanceOf(
            '\\SanchoBBDO\\Codes\\DumpWriter\\ConsoleDumpWriter',
            $this->command->getDumpWriter()
        );
    }
}
