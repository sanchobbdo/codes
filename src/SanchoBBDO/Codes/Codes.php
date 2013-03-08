<?php

namespace SanchoBBDO\Codes;

use SanchoBBDO\Codes\Coder\Coder;
use SanchoBBDO\Codes\Coder\CoderInterface;
use Symfony\Component\Config\Definition\Processor;

class Codes implements \Iterator
{
    private $coder;
    private $offset;
    private $limit;

    protected $position;

    public static function from($config = array())
    {
        $config = Utils::processConfig(new CodesConfiguration(), $config);

        $coderClass = Utils::arrayGetAndUnsetKey($config['coder'], 'class');

        $coder = new $coderClass($config['coder']);
        $codes = new Codes($coder, $config['offset'], $config['limit']);

        return $codes;
    }

    public function __construct($coder, $offset = 0, $limit = null)
    {
        $this->setCoder($coder);
        $this->setOffset($offset);
        $this->setLimit($limit);
        $this->rewind();
    }

    public function current()
    {
        return $this->getCoder()->encode($this->position);
    }

    public function rewind()
    {
        $this->position = $this->getOffset();
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return $this->position < $this->getOffset() + $this->getLimit();
    }

    public function getCoder()
    {
        return $this->coder;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    protected function setCoder(CoderInterface $coder)
    {
        $this->coder = $coder;
    }

    protected function setOffset($offset)
    {
        $this->offset = $offset;
    }

    protected function setLimit($limit = null)
    {
        if (null === $limit) {
            $limit = pow(36, 4);
        }

        $this->limit = $limit;
    }
}
