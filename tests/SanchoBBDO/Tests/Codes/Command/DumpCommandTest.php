<?php

namespace SanchoBBDO\Tests\Codes\Command;

use SanchoBBDO\Codes\Command\DumpCommand;

class DumpCommandTest extends CommandTestCase
{
    protected function createCommand()
    {
        return new DumpCommand('dump');
    }

    public function testDumpsCodesToOutout()
    {
        $output = $this->executeDefaultCommnad();
        $this->assertGreaterThan(1, count(explode("\n", $output)));
    }
}
