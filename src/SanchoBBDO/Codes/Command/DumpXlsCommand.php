<?php

namespace SanchoBBDO\Codes\Command;

use Exporter\Writer\XlsWriter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpXlsCommand extends AbstractDumpToFileCommand
{
    public function getFileWriter($file, InputInterface $input, OutputInterface $output)
    {
        return new XlsWriter($file, false);
    }
}
