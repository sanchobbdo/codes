<?php

namespace SanchoBBDO\Codes;

class CodesDumper
{
    protected $codes;
    protected $writer;

    public function __construct(Coder $coder, DumpWriter\DumpWriterInterface $writer)
    {
        $this->codes= new Codes($coder);
        $this->writer = $writer;
    }

    public function dump()
    {
        $this->writer->open();

        foreach ($this->codes as $code) {
            $this->writer->write($code);
        }

        $this->writer->close();
    }
}
