<?php

namespace SanchoBBDO\Codes\Command\Dump;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DumpDbCommand extends Command
{
    protected $dsn = 'sqlite:dump/db.sqlite3';
    protected $db;

    public function configure()
    {
        $this->db = new \PDO($this->dsn);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this
            ->setName('dump:db')
            ->setDescription('Dump generated codes to a database')
            ->addArgument(
                'howmany',
                InputArgument::OPTIONAL,
                'How many entries to generate'
            )
            ->addOption(
                'keep',
                'k',
                InputOption::VALUE_NONE
            );
    }

    public function execute(InputInterface $input, OutputInterface $output) {
        if (!$input->getOption('keep')) {
            $this->dropTable();
        }

        $this->createDbTable();

        $howmany = $input->getArgument('howmany');

        if (empty($howmany)) {
            $howmany = 10;
        }

        $codes = new \SanchoBBDO\Codes(array('secret_key' => 'lia4ufdEX7XSJWhEHdWFnKsIeMI='));
        try {
            $progress = $this->getHelperSet()->get('progress');
            $progress->start($output, $howmany);

            $t = time();

            for ($i = 0; $i < $howmany; $i++) {
                $stmt = $this->db->prepare("INSERT INTO codes (id) VALUES (:id)");
                $stmt->bindValue(':id', $codes->of($i), SQLITE3_TEXT);
                $stmt->execute();

                $progress->advance();
            }

            $total_t = time() - $t;
            $output->writeln("");
            $output->writeln("<info>Done! Generated {$howmany} entries in {$total_t} seconds.</info>");
        } catch (\PDOException $e) {
            $output->writeln("");
            $output->writeln("<error>Failed! Generated {$i} entries.</error>");
        }
    }

    protected function dropTable()
    {
        $this->db->query("DELETE FROM codes");
    }

    protected function createDbTable()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS codes (
                            id VARCHAR NOT NULL PRIMARY KEY)");
    }
}
