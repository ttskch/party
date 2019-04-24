<?php
declare(strict_types=1);

namespace Ttskch\Party\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Ttskch\Party\Service\Calculator;

class CalcCommand extends Command
{
    /**
     * @var Calculator
     */
    private $calculator;

    /**
     * @var QuestionHelper
     */
    private $question;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
        $this->question = new QuestionHelper();

        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setName('calc')
            ->setDescription('Calculate amounts of pizzas and drinks')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $headcount = (int)$this->question->ask($input, $output, new Question('How many people? : ', false));
        $budgetPerPerson = (int)$this->question->ask($input, $output, new Question('How much is budget per person? : ', false));
        $budget = $headcount * $budgetPerPerson;

        $result = $this->calculator->calculate($budget);

        (new Table($output))
            ->setHeaders(['What you have to buy', 'Num', 'Price'])
            ->setRows([
                ['Pizza (L)', $result->pizzaNum, $result->pizzaPrice],
                ['Cans of beer', $result->beerNum, $result->beerPrice],
                ['Cans of other alcohol', $result->otherAlcoholNum, $result->otherAlcoholPrice],
                ['Bottles of non-alcohol (1.5L)', $result->nonAlcoholNum, $result->nonAlcoholPrice],
                new TableSeparator(),
                ['Total', '-', $totalPrice = $result->getTotalPrice()],
                ['Average', '-', ceil($result->getTotalPrice() / $headcount)],
            ])
            ->render()
        ;

        (new Table($output))
            ->setHeaders(['Amounts per person', 'Num'])
            ->setRows([
                ['Pizza (pieces)', round($this->calculator->getPizzaPiecesPerPerson($headcount), 1)],
                ['Drink (cans/cups)', round($this->calculator->getDrinksNumPerPerson($headcount), 1)],
            ])
            ->render()
        ;
    }
}
