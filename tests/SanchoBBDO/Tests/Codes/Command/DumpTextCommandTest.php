<?php

namespace SanchoBBDO\Tests\Codes\Command;

use org\bovigo\vfs\vfsStream;
use SanchoBBDO\Codes\Command\DumpTextCommand;

class DumpTextCommandTest extends CommandTestCase
{
    protected function createCommand() {
        return new DumpTextCommand('dump');
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

        $this->executeDefaultCommnad(array('file' => $filePath));

        $this->assertNotEmpty(file_get_contents($filePath));
    }
}
