<?php

namespace SanchoBBDO\Tests\Codes\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CommandTestCase extends \PHPUnit_Framework_TestCase
{
    protected function createCommand()
    {
        throw new \Exception("Method createCommand should be overrriden");
    }

    public function setUp()
    {
        $command = $this->createCommand();

        $application = new Application();
        $application->add($command);

        $this->command = $application->find($command->getName());
        $this->commandTester = new CommandTester($this->command);
    }

    protected function executeCommand($params = array())
    {
        $this->commandTester->execute(array_merge(
            array('command' => $this->command->getName()),
            $params
        ));

        return $this->commandTester->getDisplay();
    }

    protected function executeDefaultCommnad()
    {
        return $this->executeCommand(array(
            '--secret-key' => 'yamyam',
            '--length' => 10
        ));
    }

    protected function assertInputOption($name, $shortcut, $acceptsValue, $requiredValue)
    {
        $definition = $this->command->getDefinition();
        $this->assertTrue($definition->hasOption($name));

        $option = $definition->getOption($name);
        $this->assertEquals($shortcut,      $option->getShortcut());
        $this->assertEquals($acceptsValue,  $option->acceptValue());
        $this->assertEquals($requiredValue, $option->isValueRequired());
    }

    protected function assertInputArgument($name, $isRequired)
    {
        $definition = $this->command->getDefinition();
        $this->assertTrue($definition->hasArgument($name));

        $argument = $definition->getArgument($name);
        $this->assertEquals($isRequired, $argument->isRequired());
    }
}
