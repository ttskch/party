<?php
declare(strict_types=1);

namespace Ttskch\Party\Config;

use PHPUnit\Framework\TestCase;
use Ttskch\Party\Service\Config;

/**
 * @group Config
 */
class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    protected $SUT;

    protected function setUp(): void
    {
        $this->SUT = new Config(__DIR__ . '/../fixture/config.test.yaml');
    }

    public function testGetPeopleNumForOneNonAlcohol()
    {
        $this->assertEquals(4.3, $this->SUT->getCupsNumForOneNonAlcohol());
    }

    public function testGetBeerPeopleRate()
    {
        $this->assertEquals(2 / (2 + 6 + 7), $this->SUT->getBeerPeopleRate());
    }

    public function testGetOtherAlcoholPeopleRate()
    {
        $this->assertEquals(6 / (2 + 6 + 7), $this->SUT->getOtherAlcoholPeopleRate());
    }

    public function testGetNonAlcoholPeopleRate()
    {
        $this->assertEquals(7 / (2 + 6 + 7), $this->SUT->getNonAlcoholPeopleRate());
    }

    public function testGetDrinksNumForOnePizza()
    {
        $this->assertEquals(1 / (2.5 / 8), $this->SUT->getDrinksNumForOnePizza());
    }

    public function testGetDrinksAndOnePizzaTotalPrice()
    {
        // pizza: 3000
        // beer: 230
        // other_alcohol: 200
        // non_alcohol: 200

        $beerPeopleRate = 2 / (2 + 6 + 7);
        $otherAlcoholRate = 6 / (2 + 6 + 7);
        $nonAlcoholRate = 7 / (2 + 6 + 7);

        $averagePriceOfOneDrink = array_sum([
            230 * $beerPeopleRate,
            200 * $otherAlcoholRate,
            (200 / 4.3) * $nonAlcoholRate,
        ]);

        $expected = (1 / (2.5 / 8)) * $averagePriceOfOneDrink + 3000;

        $this->assertEquals($expected, $this->SUT->getOnePizzaAndDrinksTotalPriceForOnePIzza());
    }
}
