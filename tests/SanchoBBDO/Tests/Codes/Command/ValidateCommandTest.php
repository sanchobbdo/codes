<?php

namespace SanchoBBDO\Tests\Codes\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use SanchoBBDO\Codes\Command\ValidateCommand;
use SanchoBBDO\Tests\Codes\CodesFactory;

class ValidateCommandTest extends \PHPUnit_Framework_TestCase
{
    protected $command;
    protected $commandTester;

    public function setUp()
    {
        $command = new ValidateCommand('validate');
        $command->setCodes(CodesFactory::createCodes());

        $application = new Application();
        $application->add($command);

        $this->command = $application->find('validate');
        $this->commandTester = new CommandTester($command);
    }

    protected function execute($params = array())
    {
        $params['command'] = 'validate';
        $this->commandTester->execute($params);
    }

    protected function getDisplay()
    {
        return $this->commandTester->getDisplay();
    }

    public function testExecute()
    {
        $codesCollection = $this->command->getCodes();

        $codes = array();
        foreach ($codesCollection as $code) {
            $codes[$code] = 'valid';
            $codes[substr($code, 0, -1).'x'] = 'invalid';
        }

        $this->execute(array('codes' => array_keys($codes)));

        foreach ($codes as $code => $validity) {
            $this->assertRegExp("/{$code}.*?\s{$validity}/", $this->getDisplay());
        }
    }

    /**
     * @dataProvider incompleteParametersProvider
     */
    public function testRequiredParameters($params, $param, $initializer = null, $message = 'Not enough')
    {
        if ($initializer) {
            $initializer($this->command);
        }

        try {
            $this->execute($params);
            $this->fail("{$param} is not required");
        } catch (\RuntimeException $e) {
            if (!preg_match("/{$message}/", $e->getMessage())) {
                throw $e;
            }
        }
    }

    public function incompleteParametersProvider()
    {
        return array(

            // Empty codes
            array(array(), 'codes', function ($command) {
                $command->setCodes(CodesFactory::createCodes());
            }),

            // Empty config
            array(array('codes' => array('a')), 'config', function ($command) {
                $command->setCodes(null);
            }, 'config'),

        );
    }
}
