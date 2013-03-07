<?php

namespace SanchoBBDO\Codes\Command;

use SanchoBBDO\Codes\Command\AbstractDumpCommand;
use SanchoBBDO\Codes\DumpWriter\ConsoleDumpWriter;

class DumpCommand extends AbstractDumpCommand
{
    protected function init()
    {

    }

    public function getDumpWriter()
    {
        return new ConsoleDumpWriter($this->getOutput());
    }
}
