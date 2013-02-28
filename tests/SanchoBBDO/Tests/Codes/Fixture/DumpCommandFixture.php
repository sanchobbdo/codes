<?php

namespace SanchoBBDO\Tests\Codes\Fixture;

use SanchoBBDO\Codes\Command\AbstractDumpCommand;

class DumpCommandFixture extends AbstractDumpCommand
{
    protected $action = 'test';

    public function getDumpWriter()
    {
        return new DumpWriterFixture;
    }
}
