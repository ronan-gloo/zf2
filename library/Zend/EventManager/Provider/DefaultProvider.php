<?php

namespace Zend\EventManager\Provider;

use Zend\EventManager\Exception\InvalidArgumentException;

class DefaultProvider implements ProviderInterface, EventClassAwareInterface
{
    /**
     * @var string
     */
    protected $eventClass = 'Zend\EventManager\Event';

    /**
     * Set the event class to utilize
     *
     * @param $eventClass
     * @throws \Zend\EventManager\Exception\InvalidArgumentException
     * @return $this
     */
    public function setEventClass($eventClass)
    {
        if (! class_implements($eventClass, 'Zend\Event\EventInterface')) {
            throw new InvalidArgumentException(sprintf(
                'Expecting a class that implements Zend\Event\EventInterface, %s given', $eventClass
            ));
        }
        $this->eventClass = $eventClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getEventClass()
    {
        return $this->eventClass;
    }

    /**
     * @param $eventName
     * @param $target
     * @param $parameters
     * @return \Zend\EventManager\EventInterface
     */
    public function get($eventName, $target = null, $parameters = array())
    {
        $event = new $this->eventClass();
        $event->setName($eventName);
        $event->setTarget($target);
        $event->setParams($parameters);

        return $event;
    }
}