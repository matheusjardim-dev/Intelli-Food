<?php
namespace App\Action;


class Action
{
    private $container;

    function __construct($container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        // TODO: Implement __get() method.
        if ($this->container->$property)
        {
            return $this->container[$property];
        }
    }
}
