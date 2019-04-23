<?php
declare(strict_types=1);

namespace Ttskch\Party\Service;

class Calculator
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function calculate(int $headcount, int $budget): Result
    {
        $result = new Result();

        $result->totalPizzaNum = (int)floor($budget / $this->config->getOnePizzaAndDrinksTotalPriceForOnePizza());

        $totalDrinksNum = (int)floor($result->totalPizzaNum * $this->config->getDrinksNumForOnePizza());
        $result->totalBeerNum = (int)ceil($totalDrinksNum * $this->config->getBeerPeopleRate());
        $result->totalOtherAlcoholNum = (int)ceil($totalDrinksNum * $this->config->getOtherAlcoholPeopleRate());
        $result->totalNonAlcoholNum = (int)ceil($totalDrinksNum * $this->config->getNonAlcoholPeopleRate() / $this->config->getCupsNumForOneNonAlcohol());

        // just do {num} * {unit price}
        $result->totalPizzaPrice = $result->totalPizzaNum * $this->config->getUnitPrice('pizza');
        $result->totalBeerPrice = $result->totalBeerNum * $this->config->getUnitPrice('beer');
        $result->totalOtherAlcoholPrice = $result->totalOtherAlcoholNum * $this->config->getUnitPrice('other_alcohol');
        $result->totalNonAlcoholPrice = $result->totalNonAlcoholNum * $this->config->getUnitPrice('non_alcohol');

        $result->pizzaPiecesPerPerson = $result->totalPizzaNum * Config::PIZZA_PIECES / $headcount;
        $result->drinksNumPerPerson = ($result->totalBeerNum + $result->totalOtherAlcoholNum + $result->totalNonAlcoholNum * $this->config->getCupsNumForOneNonAlcohol()) / $headcount;

        return $result;
    }
}
