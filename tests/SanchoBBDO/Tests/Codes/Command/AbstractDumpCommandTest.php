<?php

namespace SanchoBBDO\Tests\Codes\Command;

use SanchoBBDO\Codes\Command\AbstractDumpCommand;
use SanchoBBDO\Tests\Codes\Fixture\DumpCommandFixture;
use SanchoBBDO\Tests\Codes\Fixture\DumpWriterFixture;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class AbstractDumpCommandTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $application = new Application();

        $command = new DumpCommandFixture;
        $application->add($command);

        $this->command = $application->find($command->getName());
        $this->definition = $this->command->getDefinition();

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

    protected function checkOption($name, $shortcut = null, $required = false)
    {
        try {
            $option = $this->definition->getOption($name);
            $this->assertEquals($shortcut, $option->getShortcut());
            if ($required) {
                $this->assertTrue($option->isValueRequired());
            } else {
                $this->assertFalse($option->isValueRequired());
            }
        } catch (\InvalidArgumentException $e) {
            $this->fail("Option {$name} is not set");
        }
    }

    public function testSetsDumpAsNameIfActionIsNotDeclared()
    {
        $command = $this->getMockForAbstractClass('\\SanchoBBDO\\Codes\\Command\AbstractDumpCommand');
        $this->assertEquals('dump', $command->getName());
    }

    public function testSetNameAsDumpSemicolonActionIFActionIsDeclared()
    {
        $this->assertEquals('dump:test', $this->command->getName());
    }

    /**
     * @dataProvider actionsProvider
     */
    public function testSetActionSetName($action)
    {
        $this->command->setAction($action);
        $this->assertEquals("dump:{$action}", $this->command->getName());
    }

    public function actionsProvider()
    {
        return array(
            array('foo'),
            array('bar'),
            array('pum'),
            array('pam')
        );
    }

    public function testSecretKeyOption()
    {
        $this->checkOption('secret-key', 'k', true);
    }

    public function testLengthOption()
    {
        $this->checkOption('length', 'l', true);
    }

    public function testSecretKeyOptionIsRequired()
    {
        $this->assertRegExp('/secret-key/', $this->executeCommand());
    }

    public function testCallsGetDumpWriterOnExecute()
    {
        $writer = new DumpWriterFixture;
        $command = $this->getMockForAbstractClass('\\SanchoBBDO\\Codes\\Command\AbstractDumpCommand');
        $command->expects($this->once())
                ->method('getDumpWriter')
                ->will($this->returnValue($writer));

        $application = new Application();
        $application->add($command);
        $commandTester = new CommandTester($application->find('dump'));
        $commandTester->execute(array(
            'command' => 'dump',
            '--secret-key' => 'fum',
            '--length' => 10
        ));
    }
}
