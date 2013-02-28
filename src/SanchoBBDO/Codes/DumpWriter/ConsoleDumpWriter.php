<?php

namespace SanchoBBDO\Codes\DumpWriter;

use Symfony\Component\Console\Output\OutputInterface;

class ConsoleDumpWriter implements DumpWriterInterface
{
    protected $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function open()
    {

    }

    public function write($code)
    {
        $this->output->writeln($code);
    }

    public function close()
    {

    }
}
