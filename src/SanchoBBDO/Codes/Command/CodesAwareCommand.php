<?php

namespace SanchoBBDO\Codes\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

use SanchoBBDO\Codes\Codes;
use SanchoBBDO\Codes\CodesBuilder;

abstract class CodesAwareCommand extends Command
{
    private $codes;

    public function setCodes(Codes $codes)
    {
        $this->codes = $codes;
    }

    public function getCodes()
    {
        return $this->codes;
    }
}
