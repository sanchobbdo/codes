<?php

namespace SanchoBBDO\Codes\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractDumpToFileCommand extends AbstractDumpCommand
{
    function init()
    {
        $this
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'File path to dump codes to'
            );
    }

    function getWriter(InputInterface $input, OutputInterface $output)
    {
        return $this->getFileWriter($input->getArgument('file'), $input, $output);
    }

    abstract public function getFileWriter($file, InputInterface $input, OutputInterface $output);
}
