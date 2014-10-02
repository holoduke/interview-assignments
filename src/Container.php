<?php

namespace EyeOpen;

class Container
{
    private $dataSets = array();

    public function addDataSet(DataSet $dataSet)
    {
        $this->dataSets[] = $dataSet;
    }

    protected function getValueFromDataSet($dataSet, $key)
    {
        $method = 'get' . ucfirst($key);

        if (method_exists($dataSet, $method)) {
            return $dataSet->$method();
        } elseif ($dataSet instanceof ArrayObject && isset($dataSet->$key)) {
            return $dataSet->$key;
        }

        return null;
    }

    public function toFlatArray()
    {
        $return = array();
        foreach ($this->dataSets as $dataSet) {
            foreach (array_keys($dataSet->toArray()) as $key) {
                if (!isset($return[$key])) {
                    $return[$key] = $this->getValueFromDataSet($dataSet, $key);
                }
            }
        }

        return $return;
    }

    public function toFlatArrayNew()
    {
        $ret = [];
        foreach ($this->dataSets as $dataSet) {
            $data = $dataSet->toArray();

            $ret = array_merge($data, $ret);
        }

        return $ret;
    }
}