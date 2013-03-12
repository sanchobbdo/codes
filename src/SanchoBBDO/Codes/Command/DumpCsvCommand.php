<?php

namespace SanchoBBDO\Codes\Command;

use Exporter\Writer\CsvWriter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCsvCommand extends AbstractDumpToFileCommand
{
    public function init()
    {
        parent::init();

        $this
            ->addOption(
                'delimiter',
                'd',
                InputOption::VALUE_REQUIRED,
                'CSV delimiter',
                ','
            )
            ->addOption(
                'enclosure',
                'e',
                InputOption::VALUE_REQUIRED,
                'CSV enclosure',
                '"'
            )
            ->addOption(
                'escape',
                's',
                InputOption::VALUE_REQUIRED,
                'CSV escape',
                '\\\\'
            );
    }

    public function getFileWriter($file, InputInterface $input, OutputInterface $output)
    {
        return new CsvWriter(
            $file,
            $input->getOption('delimiter'),
            $input->getOption('enclosure'),
            $input->getOption('escape'),
            false
        );
    }
}
