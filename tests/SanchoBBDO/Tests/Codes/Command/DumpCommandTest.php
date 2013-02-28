<?php

namespace SanchoBBDO\Tests\Codes\Command;

use SanchoBBDO\Codes\Command\DumpCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class DumpCommandTest extends \PHPUnit_Framework_TestCase
{
    protected function executeCommand($params = array())
    {
        $this->commandTester->execute(array_merge(
            array('command' => $command->getName()),
            $params
        ));
    }

    public function setUp()
    {
        $application = new Application();
        $application->add(new DumpCommand);

        $this->command = $application->find('dump');
        $this->definition = $this->command->getDefinition();

        $this->commandTester = new CommandTester($this->command);
    }

    public function testSecretKeyOption()
    {
        try {
            $option = $this->definition->getOption('secret-key');
            $this->assertEquals('k', $option->getShortcut());
            $this->assertTrue($option->isValueRequired());
        } catch (\InvalidArgumentException $e) {
            $this->fail("Option secret-key is not set");
        }
    }

    public function testLengthOption()
    {
        try {
            $option = $this->definition->getOption('length');
            $this->assertEquals('l', $option->getShortcut());
            $this->assertTrue($option->isValueRequired());
        } catch (\InvalidArgumentException $e) {
            $this->fail("Option length is not set");
        }
    }
}
