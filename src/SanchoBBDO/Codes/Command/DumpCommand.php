<?php

namespace SanchoBBDO\Codes\Command;

use SanchoBBDO\Codes\Command\AbstractDumpCommand;
use SanchoBBDO\Codes\DumpWriter\ConsoleDumpWriter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends AbstractDumpCommand
{
    protected function init()
    {

    }

    protected function getDumpWriter(InputInterface $input, OutputInterface $output)
    {
        return new ConsoleDumpWriter($output);
    }
}
