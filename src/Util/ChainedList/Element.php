<?php

namespace App\Util\ChainedList;

class Element
{
    /**
     * @var mixed
     */
    private $element;

    /**
     * @var Element
     */
    private $previous;

    /**
     * @var Element
     */
    private $next;

    public function __construct($element) {
        $this->element = $element;
    }

    /**
     * @return mixed
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @param mixed $element
     */
    public function setElement($element): void
    {
        $this->element = $element;
    }

    /**
     * @return Element
     */
    public function getPrevious(): Element
    {
        return $this->previous;
    }

    /**
     * @param Element $previous
     */
    public function setPrevious(?Element $previous): void
    {
        $this->previous = $previous;
    }

    /**
     * @return Element
     */
    public function getNext(): Element
    {
        return $this->next;
    }

    /**
     * @param Element $next
     */
    public function setNext(?Element $next): void
    {
        $this->next = $next;
    }
}