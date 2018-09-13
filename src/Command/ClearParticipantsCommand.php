<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ClearParticipantsCommand extends ContainerAwareCommand
{
    protected function configure() : void
    {
        $this
            ->setName('board:clear-participants')
            ->setDescription('Removes all participants for a fresh start')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $connection = $this->getContainer()->get('database_connection');

        // delete participants
        $connection->executeQuery('DELETE FROM participant;');
        $connection->executeQuery('DELETE FROM company;');

        $io = new SymfonyStyle($input, $output);
        $io->success('Deleted all participants!');
    }
}
