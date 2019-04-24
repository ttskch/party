<?php

declare(strict_types=1);

namespace Ttskch\Party;

use Symfony\Component\Console\Application;
use Ttskch\Party\Command\CalcCommand;
use Ttskch\Party\Command\ConfigCommand;
use Ttskch\Party\Service\Calculator;
use Ttskch\Party\Service\Config;

class Party
{
    public function run() : void
    {
        $console = new Application();
        $console->setName('party');
        $console->add($calc = new CalcCommand(new Calculator(new Config())));
        $console->add(new ConfigCommand());
        $console->setDefaultCommand($calc->getName());
        $console->run();
    }
}
