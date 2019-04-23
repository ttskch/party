<?php
declare(strict_types=1);

namespace Ttskch\Party\Service;

class Result
{
    /**
     * @var int
     */
    public $totalPizzaNum;

    /**
     * @var int
     */
    public $totalBeerNum;

    /**
     * @var int
     */
    public $totalOtherAlcoholNum;

    /**
     * @var int
     */
    public $totalNonAlcoholNum;

    /**
     * @var int
     */
    public $totalPizzaPrice;

    /**
     * @var int
     */
    public $totalBeerPrice;

    /**
     * @var int
     */
    public $totalOtherAlcoholPrice;

    /**
     * @var int
     */
    public $totalNonAlcoholPrice;

    /**
     * @var float
     */
    public $pizzaPiecesPerPerson;

    /**
     * @var float
     */
    public $drinksNumPerPerson;

    public function __get($name)
    {
        if ($name === 'totalPrice') {
            return $this->totalPizzaPrice + $this->totalBeerPrice + $this->totalOtherAlcoholPrice + $this->totalNonAlcoholPrice;
        }
    }
}
