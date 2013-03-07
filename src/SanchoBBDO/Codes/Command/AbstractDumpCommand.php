<?php

namespace SanchoBBDO\Codes\Command;

use SanchoBBDO\Codes\Codes;
use SanchoBBDO\Codes\CodesDumper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractDumpCommand extends Command
{
    private $input;
    private $output;

    public function configure()
    {
        $this
            ->setDescription('Dumps codes to screen')
            ->addOption(
                'secret-key',
                'k',
                InputOption::VALUE_REQUIRED,
                'Secret key to generate codes'
            )
            ->addOption(
                'offset',
                'f',
                InputOption::VALUE_REQUIRED,
                'How many codes to skip'
            )
            ->addOption(
                'limit',
                'l',
                InputOption::VALUE_REQUIRED,
                'How many codes to generate'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        try {
            $dumper = new CodesDumper($this->getCodes(), $this->getDumpWriter());
            $dumper->dump();
        } catch (\Exception $e) {
            $this->getOutput()->writeln('<error>'.$e->getMessage().'</error>');
        }
    }

    protected function getCodes()
    {
        return Codes::from(array(
            'offset' => $this->input->getOption('offset'),
            'limit' => $this->input->getOption('limit'),
            'secret_key' => $this->input->getOption('secret-key')
        ));
    }

    public function getInput()
    {
        return $this->input;
    }

    public function getOutput()
    {
        return $this->output;
    }

    abstract public function getDumpWriter();
}
