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
     * @var int
     */
    public $pizzaPrice;

    /**
     * @var int
     */
    public $beerPrice;

    /**
     * @var int
     */
    public $otherAlcoholPrice;

    /**
     * @var int
     */
    public $nonAlcoholPrice;

    public function __get($name)
    {
        if ($name === 'totalPrice') {
            return $this->pizzaPrice + $this->beerPrice + $this->otherAlcoholPrice + $this->nonAlcoholPrice;
        }
    }
}
