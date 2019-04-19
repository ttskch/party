<?php
declare(strict_types=1);

namespace Ttskch\Party;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class Party
{
    const PIZZA_PIECES = 8;

    public function run()
    {
        $config = require __DIR__ . '/../config/config.php';

        $console = new Application();

        $command = $console
            ->register('calc')
            ->setDescription('Calculate amounts of pizzas and drinks')
            ->setCode(function (InputInterface $input, OutputInterface $output) use ($config) {

                $question = new QuestionHelper();

                $headcount = $question->ask($input, $output, new Question('How many people? : ', false));
                $budgetPerPerson = $question->ask($input, $output, new Question('How much is budget per person? : ', false));
                $budget = $headcount * $budgetPerPerson;

                $drinksNumForOnePizza = 1 / ($config['pizza_pieces_for_one_drink'] / self::PIZZA_PIECES);

                $rates = [
                    'beer' => $config['distribution_rate']['beer'] / $denominator = array_sum($config['distribution_rate']),
                    'other_alcohol' => $config['distribution_rate']['other_alcohol'] / $denominator,
                    'non_alcohol' => $config['distribution_rate']['non_alcohol'] / $denominator,
                ];

                $averagePriceOfOneDrink = array_sum([
                    $config['unit_price']['beer'] * $rates['beer'],
                    $config['unit_price']['other_alcohol'] * $rates['other_alcohol'],
                    ($config['unit_price']['non_alcohol'] / $config['people_for_one_non_alcohol']) * $rates['non_alcohol'],
                ]);

                $drinksPriceForOnePizza = $drinksNumForOnePizza * $averagePriceOfOneDrink;

                $drinksAndOnePizzaTotalPrice = $drinksPriceForOnePizza + $config['unit_price']['pizza'];

                $num = [
                    'pizza' => floor($pizzaNum = $budget / $drinksAndOnePizzaTotalPrice),
                    'beer' => ceil(($drinksNum = $pizzaNum * $drinksNumForOnePizza) * $rates['beer']),
                    'other_alcohol' => ceil($drinksNum * $rates['other_alcohol']),
                    'non_alcohol' => ceil($drinksNum * $rates['non_alcohol'] / $config['people_for_one_non_alcohol']),
                ];

                $price = [
                    'pizza' => ceil($num['pizza'] * $config['unit_price']['pizza']),
                    'beer' => ceil($num['beer'] * $config['unit_price']['beer']),
                    'other_alcohol' => ceil($num['other_alcohol'] * $config['unit_price']['other_alcohol']),
                    'non_alcohol' => ceil($num['non_alcohol'] * $config['unit_price']['non_alcohol']),
                ];

                (new Table($output))
                    ->setHeaders(['What you have to buy', 'Num', 'Price'])
                    ->setRows([
                        ['Pizza (L)', $num['pizza'], $price['pizza']],
                        ['Cans of beer', $num['beer'], $price['beer']],
                        ['Cans of other alcohol', $num['other_alcohol'], $price['other_alcohol']],
                        ['Bottles of non-alcohol (1.5L)', $num['non_alcohol'], $price['non_alcohol']],
                        new TableSeparator(),
                        ['Total', '-', $totalPrice = array_sum($price)],
                        ['Average', '-', ceil($totalPrice / $headcount)],
                    ])
                    ->render()
                ;

                (new Table($output))
                    ->setHeaders(['Amounts per person', 'Num'])
                    ->setRows([
                        ['Pizza (pieces)', round($num['pizza'] * self::PIZZA_PIECES / $headcount, 1)],
                        ['Drink (cans/cups)', round(($num['beer'] + $num['other_alcohol'] + $num['non_alcohol'] * $config['people_for_one_non_alcohol']) / $headcount, 1)],
                    ])
                    ->render()
                ;
            })
        ;

        $console->setName('party');
        $console->setDefaultCommand($command->getName());
        $console->run();
    }
}