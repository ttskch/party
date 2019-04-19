<?php
declare(strict_types=1);

namespace Ttskch\Party;

use Symfony\Component\Console\Application;
use Ttskch\Party\Command\CalcCommand;

class Party
{
    public function run()
    {
        $console = new Application();
        $console->setName('party');
        $console->add($calc = new CalcCommand());
        $console->setDefaultCommand($calc->getName());
        $console->run();
    }
}
