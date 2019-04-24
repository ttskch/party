<?php

declare(strict_types=1);

namespace Ttskch\Party\Entity;

class Result
{
    /**
     * @var int
     */
    public $pizzaNum;

    /**
     * @var int
     */
    public $beerNum;

    /**
     * @var int
     */
    public $otherAlcoholNum;

    /**
     * @var int
     */
    public $nonAlcoholNum;

    /**
     * @var float
     */
    public $pizzaPrice;

    /**
     * @var float
     */
    public $beerPrice;

    /**
     * @var float
     */
    public $otherAlcoholPrice;

    /**
     * @var float
     */
    public $nonAlcoholPrice;

    public function getTotalPrice() : float
    {
        return $this->pizzaPrice + $this->beerPrice + $this->otherAlcoholPrice + $this->nonAlcoholPrice;
    }
}
