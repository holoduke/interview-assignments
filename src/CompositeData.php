<?php
namespace EyeOpen;

/**
 * Hybrid class to call get methods from a group of objects used by the copy data injector.
 */
class CompositeData implements Arrayable
{
    /**
     * @var array
     */
    private $objects = array();

    /**
     * Used to print the current date into the footer.
     * @var string
     */
    public $currentDate;

    /**
     * Constructs copy data class.
     */
    public function __construct()
    {
        $this->currentDate = date('j F Y');
    }

    /**
     * Add object to the stack.
     *
     * @param Arrayable $object
     */
    public function addObject(Arrayable $object)
    {
        $this->objects[] = $object;
    }

    /**
     * Call getter method on 1 of the objects.
     *
     * @param string $name
     *
     * @return null
     */
    public function __get($name)
    {
        foreach ($this->objects as $object) {
            $value = $this->getValueFromObject($object, $name);

            if($value !== null) {
                return $value;
            }
        }

        return null;
    }

    protected function getValueFromObject($object, $name)
    {
        $method = 'get'.ucfirst($name);

        if (method_exists($object, $method)) {
            return $object->$method();
        } elseif ($object instanceof ArrayObject && isset($object->$name)) {
            return $object->$name;
        }

        return null;
    }

    /**
     * Check if getter method exists.
     *
     * @param string $name
     *
     * @return boolean
     */
    public function __isset($name)
    {
        $method = 'get'.ucfirst($name);

        foreach ($this->objects as $object) {
            if (method_exists($object, $method) || ($object instanceof ArrayObject && isset($object->$name))) {
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $return = array();
        foreach($this->objects as $object) {
            foreach(array_keys($object->toArray()) as $key) {
                if(!isset($return[$key])) {
                    $return[$key] = $this->getValueFromObject($object, $key);
                }
            }
        }

        return $return;
    }
}