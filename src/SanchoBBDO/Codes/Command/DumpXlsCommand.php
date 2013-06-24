<?php

namespace SanchoBBDO\Codes\Command;

use Exporter\Writer\XlsWriter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @deprecated DumpXlsCommand is deprectated since v1.1.0 and will be removed on
 * v1.2.0. Use DumpCodesCommand instead.
 */
class DumpXlsCommand extends AbstractDumpToFileCommand
{
    public function __construct($name = null)
    {
        trigger_error(
            "DumpXlsCommand is deprectated since v1.1.0 and will be removed " .
            "on v1.2.0. Use DumpCodesCommand instead.",
            E_USER_DEPRECATED
        );

        parent::__construct($name);
    }

    public function getFileWriter($file, InputInterface $input, OutputInterface $output)
    {
        return new XlsWriter($file, false);
    }
}
