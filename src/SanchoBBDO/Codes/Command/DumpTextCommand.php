<?php

namespace SanchoBBDO\Codes\Command;

use SanchoBBDO\Codes\Command\AbstractDumpCommand;
use SanchoBBDO\Codes\DumpWriter\TextDumpWriter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpTextCommand extends AbstractDumpCommand
{
    public function init()
    {
        $this
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'Text file to dump codes to'
            );
    }

    protected function getDumpWriter(InputInterface $input, OutputInterface $output)
    {
        return new TextDumpWriter($input->getArgument('file'));
    }
}
