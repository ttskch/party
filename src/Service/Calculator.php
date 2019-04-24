<?php
declare(strict_types=1);

namespace Ttskch\Party\Service;

use Ttskch\Party\Entity\Result;
use Ttskch\Party\Exception\LogicException;

/**
 * Calculate from config information and user input (headcount and budget)
 */
class Calculator
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Result
     */
    private $result;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function calculate(int $budget): Result
    {
        $result = new Result();

        $rates = $this->config->getPurchaseRates();

        $totalPrice = array_sum(array_map(function ($rate, $name) {
            return $this->config->getUnitPrice($name) * $rate;
        }, $rates, array_keys($rates)));

        $num = $budget / $totalPrice;

        $result->pizzaNum = (int)round($rates['pizza'] * $num);
        $result->beerNum = (int)round($rates['beer'] * $num);
        $result->otherAlcoholNum = (int)round($rates['other_alcohol'] * $num);
        $result->nonAlcoholNum = (int)round($rates['non_alcohol'] * $num);

        $result->pizzaPrice = $this->config->getUnitPrice('pizza') * $result->pizzaNum;
        $result->beerPrice = $this->config->getUnitPrice('beer') * $result->beerNum;
        $result->otherAlcoholPrice = $this->config->getUnitPrice('other_alcohol') * $result->otherAlcoholNum;
        $result->nonAlcoholPrice = $this->config->getUnitPrice('non_alcohol') * $result->nonAlcoholNum;

        return $this->result = $result;
    }

    public function getPizzaPiecesPerPerson(int $headcount): float
    {
        $this->ensureCalculated();

        return Config::PIZZA_PIECES * $this->result->pizzaNum / $headcount;
    }

    public function getDrinksNumPerPerson(int $headcount): float
    {
        $this->ensureCalculated();

        return ($this->result->beerNum + $this->result->otherAlcoholNum + $this->result->nonAlcoholNum * $this->config->getCupsNumForOneNonAlcohol()) / $headcount;
    }

    private function ensureCalculated()
    {
        if (!$this->result) {
            throw new LogicException('Not calculated yet.');
        }
    }
}
