<?php

namespace SanchoBBDO\Tests\Codes\Command;

use org\bovigo\vfs\vfsStream;
use SanchoBBDO\Codes\Command\DumpTextCommand;

class DumpTextCommandTest extends CommandTestCase
{
    protected function createCommand() {
        return new DumpTextCommand;
    }

    public function testActionIsTxt()
    {
        $this->assertEquals('txt', $this->command->getAction());
    }

    public function testFileArgument()
    {
        $this->assertInputArgument('file', true);
    }

    public function testDumpsFileInGivenPath()
    {
        $root = vfsStream::setup('dump');
        $file = 'dump.txt';
        $filePath = vfsStream::url("dump/{$file}");

        $this->executeCommand(array(
            '--secret-key' => 'dum',
            '--limit' => 10,
            'file' => $filePath
        ));

        $this->assertNotEmpty(file_get_contents($filePath));
    }
}
