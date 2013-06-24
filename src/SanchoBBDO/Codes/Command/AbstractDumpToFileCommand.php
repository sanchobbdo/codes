<?php

namespace SanchoBBDO\Codes\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @deprecated AbstractDumpToFileCommand is deprectated since v1.1.0 and will be
 * removed on v1.2.0. Use AbstractCodesCommand instead.
 */
abstract class AbstractDumpToFileCommand extends AbstractDumpCommand
{
    public function __construct($name = null)
    {
        trigger_error(
            "AbstractDumpToFileCommand is deprectated since v1.1.0 and will " .
            "be removed on v1.2.0. Use AbstractCodesCommand instead.",
            E_USER_DEPRECATED
        );

        parent::__construct($name);
    }

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

    /**
     * @return \Exporter\Writer\WriterIntreface;
     */
    abstract public function getFileWriter($file, InputInterface $input, OutputInterface $output);
}
