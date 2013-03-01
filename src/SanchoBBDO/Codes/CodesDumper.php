<?php

namespace SanchoBBDO\Codes;

class CodesDumper
{
    protected $codes;
    protected $writer;

    public function __construct(Codes $codes, DumpWriter\DumpWriterInterface $writer)
    {
        $this->codes = $codes;
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
