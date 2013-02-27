<?php

namespace SanchoBBDO\Codes\DumpWriter;

interface DumpWriterInterface
{
    public function open();
    public function write($code);
    public function close();
}

