<?php

namespace SanchoBBDO\Tests\Codes\Command;

use SanchoBBDO\Codes\Command\DumpCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class DumpCommandTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $command = new DumpCommand;

        $application = new Application();
        $application->add($command);

        $this->command = $application->find('dump');
        $this->commandTester = new CommandTester($this->command);
    }

    public function testGetDumpWriterReturnsAConsoleDumpWriter()
    {
        $this->commandTester->execute(array(
            'command' => 'dump',
            '--secret-key' => 'dsfdsfsad',
            '--length' => 10
        ));

        $this->assertInstanceOf(
            '\\SanchoBBDO\\Codes\\DumpWriter\\ConsoleDumpWriter',
            $this->command->getDumpWriter()
        );
    }
}
