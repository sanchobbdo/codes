<?php

namespace SanchoBBDO\Tests\Codes\Command\Test;

use SanchoBBDO\Codes\Command\Dump\DumpDbCommand;
use SanchoBBDO\Codes\Codes;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class DumpDbCommandTest extends \PHPUnit_Framework_TestCase
{
    protected $dsn = 'sqlite:dump/db.sqlite3';

    protected function executeCommand($num = 1, $keep = false)
    {
        $application = new Application();
        $application->add(new DumpDbCommand());

        $command = $application->find('dump:db');
        $this->commandTester = new CommandTester($command);
        $this->commandTester->execute(array('command' => $command->getName(),
                                            'howmany' => $num,
                                            '--keep' => $keep));
    }

    public function setUp()
    {
        $this->db = new \PDO($this->dsn);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function testCreatesDbTable()
    {
        $this->executeCommand();

        try {
            $this->db->query('SELECT 1 FROM codes');
        } catch (\PDOException $e) {
            $this->fail('Table codes was not created');
        }
    }

    public function testEmptiesDbBeforeCreating()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS codes (id TEXT PRIMARY KEY)");
        $this->db->query("INSERT INTO codes (id) VALUES ('my_id_string')");

        $this->executeCommand();

        $result = $this->db->query("SELECT * FROM codes WHERE id = 'my_id_string'")->fetchAll();
        $this->assertCount(0, $result);
    }

    public function testKeepsTableDataIfFlagIsUsed()
    {
        $this->db->query("DELETE FROM codes");
        $this->db->query("CREATE TABLE IF NOT EXISTS codes (id TEXT PRIMARY KEY)");
        $this->db->query("INSERT INTO codes (id) VALUES ('my_id_string')");

        $this->executeCommand(1, true);

        $result = $this->db->query("SELECT * FROM codes WHERE id = 'my_id_string'")->fetchAll();
        $this->assertCount(1, $result);
    }

    /**
     * @dataProvider argumentDataProvider
     */
    public function testGeneratesTheGivenNumberOfEntries($num)
    {
        $this->executeCommand($num);
        $result = $this->db->query("SELECT * FROM codes")->fetchAll();
        $this->assertCount($num, $result);
    }

    public function argumentDataProvider()
    {
        return array(
            array(1),
            array(10),
            array(20)
        );
    }

    public function testNotifiesWhenFinished()
    {
        $this->executeCommand();
        $this->assertRegExp('/Done/', $this->commandTester->getDisplay());
    }

    public function testNotifiesWhenSomethingWentWrong()
    {
        $this->db->query("DELETE FROM codes");
        $this->db->query("CREATE TABLE IF NOT EXISTS codes (id TEXT PRIMARY KEY)");

        $codes = new Codes(array('secret_key' => 'lia4ufdEX7XSJWhEHdWFnKsIeMI='));
        $stmt = $this->db->prepare("INSERT INTO codes (id) VALUES (:id)");
        $stmt->bindValue(':id', $codes->of(2), SQLITE3_TEXT);
        $stmt->execute();

        $this->executeCommand(10, true);
        $this->assertRegExp('/Failed/', $this->commandTester->getDisplay());
    }
}
