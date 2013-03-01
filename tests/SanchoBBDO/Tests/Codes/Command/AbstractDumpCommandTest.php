<?php

namespace SanchoBBDO\Tests\Codes\Command;

use SanchoBBDO\Codes\Command\AbstractDumpCommand;
use SanchoBBDO\Tests\Codes\Fixture\DumpCommandFixture;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class AbstractDumpCommandTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->writer = $this->getMock('\\SanchoBBDO\\Codes\\DumpWriter\\DumpWriterInterface');
        $command = $this->getMockForAbstractClass('\\SanchoBBDO\\Codes\\Command\\AbstractDumpCommand');
        $command
            ->expects($this->any())
            ->method('getDumpWriter')
            ->will($this->returnValue($this->writer));

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

    public function testSetsDumpAsNameIfActionIsNotDeclared()
    {
        $this->assertEquals('dump', $this->command->getName());
    }

    public function testSetNameAsDumpSemicolonActionIFActionIsDeclared()
    {
        $command = new DumpCommandFixture;
        $this->assertEquals('dump:test', $command->getName());
    }

    public function testSetActionSetName()
    {
        $this->command->setAction('my-action');
        $this->assertEquals("dump:my-action", $this->command->getName());
    }

    public function testSecretKeyOption()
    {
        $this->assertInputOption('secret-key', 'k', true, true);
    }

    public function testLengthOption()
    {
        $this->assertInputOption('length', 'l', true, true);
    }

    public function testSecretKeyOptionIsRequired()
    {
        $this->assertRegExp('/secret-key/', $this->executeCommand());
    }

    public function testCallsGetDumpWriterOnExecute()
    {
        $this->command
                ->expects($this->once())
                ->method('getDumpWriter')
                ->will($this->returnValue($this->writer));
        $this->executeDefaultCommnad();
    }

    public function testCalssDumpWriterMethodsOnExecute()
    {
        $this->writer
                ->expects($this->once())
                ->method('open');

        $this->writer
                ->expects($this->exactly(10))
                ->method('write')
                ->with($this->anything());

        $this->writer
                ->expects($this->once())
                ->method('close');

        $this->executeDefaultCommnad();
    }

    public function testGetInputReturnsCommandInput()
    {
        $this->executeDefaultCommnad();
        $this->assertInstanceOf(
            'Symfony\\Component\\Console\\Input\\InputInterface',
            $this->command->getInput()
        );
    }

    public function testGetOutputReturnsCommandOutput()
    {
        $this->executeDefaultCommnad();
        $this->assertInstanceOf(
            'Symfony\\Component\\Console\\Output\\OutputInterface',
            $this->command->getOutput()
        );
    }
}
