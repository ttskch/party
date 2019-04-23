<?php
declare(strict_types=1);

namespace Ttskch\Party\Config;

use PHPUnit\Framework\TestCase;
use Ttskch\Party\Service\Calculator;
use Ttskch\Party\Service\Config;

/**
 * @group Calculator
 */
class CalculatorTest extends TestCase
{
    /**
     * @var Calculator
     */
    protected $SUT;

    protected function setUp(): void
    {
        $this->SUT = new Calculator(new Config(__DIR__ . '/../fixture/config.test.yaml'));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCalculate($headcount, $budget, $totalPizzaNum, $totalBeerNum, $totalOtherAlcoholNum, $totalNonAlcoholNum, $pizzaPiecesPerPerson, $drinksNumPerPerson)
    {
        $result = $this->SUT->calculate($headcount, $budget);

        $this->assertEquals($totalPizzaNum, $result->totalPizzaNum);
        $this->assertEquals($totalBeerNum, $result->totalBeerNum);
        $this->assertEquals($totalOtherAlcoholNum, $result->totalOtherAlcoholNum);
        $this->assertEquals($totalNonAlcoholNum, $result->totalNonAlcoholNum);
        $this->assertEquals($pizzaPiecesPerPerson, round($result->pizzaPiecesPerPerson, 1));
        $this->assertEquals($drinksNumPerPerson, round($result->drinksNumPerPerson, 1));
    }

    public function dataProvider()
    {
        return [
            [10, 10*1000, 2, 1, 3, 1, 1.6, 0.8],
            [15, 15*2000, 8, 4, 10, 3, 4.3, 1.8],
            [20, 20*3000, 17, 8, 22, 6, 6.8, 2.8],
        ];
    }
}
