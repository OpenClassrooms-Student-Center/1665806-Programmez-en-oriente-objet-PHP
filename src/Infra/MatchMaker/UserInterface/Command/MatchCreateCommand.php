<?php

/*
 * This file is part of the OpenClassRoom PHP Object Course.
 *
 * (c) Grégoire Hébert <contact@gheb.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infra\MatchMaker\UserInterface\Command;

use App\Infra\MatchMaker\Lobby;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MatchCreateCommand extends Command
{
    protected static $defaultName = 'app:encounters:create';

    private $lobby;
    private $logger;

    public function __construct(Lobby $lobby, LoggerInterface $logger)
    {
        parent::__construct();

        $this->lobby = $lobby;
        $this->logger = $logger;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create a match for every players in the lobby');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->lobby->createEncounters();
        } catch (\Exception $e) {
            $this->logger->warning('Attempt to remove a non queued player.');
        }
        $io->success('Matches (if any player available) created.');

        return Command::SUCCESS;
    }
}
