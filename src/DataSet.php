<?php

namespace EyeOpen;

class DataSet
{
    private $baz;
    private $foo;

    function __construct($baz, $foo)
    {
        $this->baz = $baz;
        $this->foo = $foo;
    }


    public function getBaz()
    {
        return $this->baz;
    }

    public function setBaz($baz)
    {
        $this->baz = $baz;
    }

    public function getFoo()
    {
        return $this->foo;
    }

    public function setFoo($foo)
    {
        $this->foo = $foo;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}