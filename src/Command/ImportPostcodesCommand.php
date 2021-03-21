<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportPostcodesCommand extends Command
{
    private const POSTCODES_URL = 'https://parlvid.mysociety.org/os/ONSPD/2020-05.zip';

    protected static $defaultName = 'import:postcodes';

    protected function configure()
    {
        $this->setDescription(
            sprintf(
                'Gets postcodes from %s and stores them in the database.',
                self::POSTCODES_URL
            )
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO import postcodes command...

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }
}
