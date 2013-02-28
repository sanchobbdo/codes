<?php

namespace SanchoBBDO\Codes\Command;

use SanchoBBDO\Codes\Codes;
use SanchoBBDO\Codes\CodesDumper;
use SanchoBBDO\Codes\DumpWriter\ConsoleDumpWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractDumpCommand extends Command
{
    protected $action;
    private $codeSettings;
    private $codes;

    public function setAction($action)
    {
        $this->action = $action;
        $this->setNameFromAction();
    }

    public function getAction()
    {
        return $this->action;
    }

    private function setNameFromAction()
    {
        $action = $this->getAction();
        $name = 'dump'.($action ? ":{$action}" : '');
        $this->setName($name);
    }

    public function configure()
    {
        if (!$this->getName()) {
            $this->setNameFromAction();
        }

        $this
            ->setDescription('Dumps codes to screen')
            ->addOption(
                'secret-key',
                'k',
                InputOption::VALUE_REQUIRED,
                'Secret key to generate codes'
            )
            ->addOption(
                'length',
                'l',
                InputOption::VALUE_REQUIRED,
                'How many codes to generate'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $secretKey = $input->getOption('secret-key');

        if (!$secretKey) {
            $output->writeln('<error>You must specify a --secret-key (-k)</error>');
            return;
        }

        $config['secret_key'] = $secretKey;

        if ($length = $input->getOption('length')) {
            $config['length'] = (int) $length;
        }

        $codes = new Codes($config);
        $dumpWriter = $this->getDumpWriter();
        $dumper = new CodesDumper($codes, $dumpWriter);
        $dumper->dump();
    }

    abstract public function getDumpWriter();
}
