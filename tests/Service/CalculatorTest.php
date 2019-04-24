<?php
declare(strict_types=1);

namespace Ttskch\Party\Service;

use PHPUnit\Framework\TestCase;
use Ttskch\Party\Exception\LogicException;

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
     * @dataProvider calculateDataProvider
     */
    public function testCalculate($budget, $pizzaNum, $beerNum, $otherAlcoholNum, $nonAlcoholNum)
    {
        $result = $this->SUT->calculate($budget);

        $this->assertEquals($pizzaNum, $result->pizzaNum);
        $this->assertEquals($beerNum, $result->beerNum);
        $this->assertEquals($otherAlcoholNum, $result->otherAlcoholNum);
        $this->assertEquals($nonAlcoholNum, $result->nonAlcoholNum);
    }

    public function calculateDataProvider()
    {
        return [
            [10000, 3, 5, 3, 1],
            [30000, 8, 16, 8, 2],
            [60000, 16, 32, 16, 4],
        ];
    }

    public function testGetPizzaPiecesPerPerson()
    {
        $this->expectException(LogicException::class);
        $this->SUT->getPizzaPiecesPerPerson(10);

        $this->SUT->calculate(10000);
        $this->assertEquals(2.4, $this->SUT->getPizzaPiecesPerPerson(10));
    }

    public function testGetDrinksNumPerPerson()
    {
        $this->expectException(LogicException::class);
        $this->SUT->getPizzaPiecesPerPerson(10);

        $this->SUT->calculate(10000);
        $this->assertEquals(1.23, $this->SUT->getPizzaPiecesPerPerson(10));
    }
}
