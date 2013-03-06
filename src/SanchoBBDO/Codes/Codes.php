<?php

namespace SanchoBBDO\Codes;

use SanchoBBDO\Codes\Coder\Coder;
use SanchoBBDO\Codes\Coder\CoderInterface;

class Codes implements \Iterator
{
    private static $defaultCoderClass = '\\SanchoBBDO\\Codes\\Coder\\Coder';

    private $coder;
    private $offset;
    private $limit;

    protected $position;

    public static function setDefaultCoderClass($className)
    {
        self::$defaultCoderClass = $className;
    }

    public static function getDefaultCoderClass()
    {
        return self::$defaultCoderClass;
    }

    public static function from($config = array())
    {
        $coderClass = self::getDefaultCoderClass();

        $coder = new $coderClass(array(
            'secret_key' => $config['secret_key']
        ));
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

    public function setCoder(CoderInterface $coder)
    {
        $this->coder = $coder;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setLimit($limit = null)
    {
        if (null === $limit) {
            $limit = pow(36, 4);
        }

        $this->limit = $limit;
    }
}
