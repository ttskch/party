<?php

declare(strict_types=1);

namespace Ttskch\Party\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ttskch\Party\Service\Config;

class ConfigCommand extends Command
{
    public function configure() : void
    {
        $this
            ->setName('config')
            ->setDescription('Generate config file');
    }

    public function execute(InputInterface $input, OutputInterface $output) : void
    {
        @mkdir(dirname($path = $_SERVER['HOME'] . Config::USER_CONFIG_FILE_PATH_UNDER_HOME_DIR), 0644, true);

        if (file_exists($path)) {
            $output->writeln(sprintf('<comment>[INFO]</comment> "%s" already exists. Modify it if you need.', $path));
        } else {
            copy(Config::DEFAULT_CONFIG_FILE_PATH, $path);
            $output->writeln(sprintf('<info>[SUCCESS]</info> "%s" is created. Modify it if you need.', $path));
        }
    }
}
