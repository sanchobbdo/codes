<?php

namespace SanchoBBDO\Codes\DumpWriter;

class StdoutDumpWriter implements DumpWriterInterface
{
    public function open()
    {

    }

    public function write($code)
    {
        print "{$code}\n";
    }

    public function close() {

    }
}
