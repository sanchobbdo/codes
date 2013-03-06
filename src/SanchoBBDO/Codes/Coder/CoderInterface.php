<?php

namespace SanchoBBDO\Codes\Coder;

interface CoderInterface
{
    public function encode($digit);
    public function isValid($code);
}
