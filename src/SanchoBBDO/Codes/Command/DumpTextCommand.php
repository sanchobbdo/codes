<?php

namespace SanchoBBDO\Codes\Command;

use SanchoBBDO\Codes\Command\AbstractDumpCommand;
use SanchoBBDO\Codes\DumpWriter\TextDumpWriter;
use Symfony\Component\Console\Input\InputArgument;

class DumpTextCommand extends AbstractDumpCommand
{
    public function configure()
    {
        parent::configure();

        $this
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'Text file to dump codes to'
            );
    }

    public function getDumpWriter()
    {
        return new TextDumpWriter($this->getInput()->getArgument('file'));
    }
}
