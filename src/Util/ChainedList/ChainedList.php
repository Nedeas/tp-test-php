<?php

namespace App\Util\ChainedList;

class ChainedList implements ChainedListInterface
{

    /**
     * @var Element
     */
    private $firstElement;

    /**
     * @var Element
     */
    private $lastElement;

    /**
     * @var Element
     */
    private $currentElement;

    /**
     * @var int
     */
    private $position = 0;

    /**
     * @var int
     */
    private $nb = 0;

    public function current()
    {
        return $this->currentElement->getElement();
    }

    public function previous()
    {
        if ($this->position > 1) {
            $this->currentElement = $this->currentElement->getPrevious();
            --$this->position;
            return true;
        }
        return false;
    }
    public function next()
    {
        if ($this->position < $this->nb) {
            $this->currentElement = $this->currentElement->getNext();
            ++$this->position;
            return true;
        }
        return false;
    }

    public function key()
    {
        return $this->position;
    }

    public function rewind()
    {
        $this->currentElement = $this->firstElement;
        $this->position = 0;
    }

    public function valid()
    {
        return $this->position <= $this->nb;
    }

    public function add($data)
    {
        $element = new Element($data);

        if (0 === $this->nb) {
            $this->firstElement = $element;
        } else {
            $element->setPrevious($this->lastElement);
            $this->lastElement->setNext($element);
        }

        $this->lastElement = $element;

        ++$this->nb;
    }

    public function remove($position)
    {
        if ($this->nb <= $position || $position < 1) {
            throw new \ValueError('invalid position');
        }

        if ($position === $this->nb && 1 === $this->nb) {
            $this->firstElement = $this->lastElement = null;
        } else {
            /** @var Element $toBeRemove */
            $toBeRemove = $this->firstElement;

            $it = 1;
            while ($it < $position) {
                $toBeRemove = $toBeRemove->getNext();
                ++$it;
            }

            if (1 === $it) {
                $this->firstElement = $toBeRemove->getNext();
                $this->firstElement->setPrevious(null);
            }
            if ($this->nb === $it) {
                $this->lastElement = $toBeRemove->getPrevious();
                $this->lastElement->setNext(null);
            }
            if (1 < $it && $this->nb > $it) {
                $toBeRemove->getPrevious()->setNext($toBeRemove->getNext());
                $toBeRemove->getNext()->setPrevious($toBeRemove->getPrevious());
            }
        }

        --$this->nb;
    }

    public function size()
    {
        return $this->nb;
    }

}