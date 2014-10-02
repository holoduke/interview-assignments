<?php

namespace EyeOpen\Test;

use EyeOpen\Container;
use EyeOpen\DataSet;

class ArrayComparisonTest extends \PHPUnit_Framework_TestCase
{
    private $container;

    public function testFlatArraysAreEqualWithoutNull()
    {
        $setA = new DataSet('setAqux', 'setABar');
        $setB = new DataSet('setBqux', 'setBbar');

        $this->container = new Container();
        $this->container->addDataSet($setA);
        $this->container->addDataSet($setB);

        $resultA = $this->container->toFlatArray();
        $resultB = $this->container->toFlatArrayNew();

        $this->assertEquals($resultA, $resultB);
    }

    public function testFlatArraysAreEqualWithNull()
    {
        $setA = new DataSet('setAqux', null);
        $setB = new DataSet('setBqux', 'setBbar');

        $this->container = new Container();
        $this->container->addDataSet($setA);
        $this->container->addDataSet($setB);

        $resultA = $this->container->toFlatArray();
        $resultB = $this->container->toFlatArrayNew();

        $this->assertEquals($resultA, $resultB);
    }
}