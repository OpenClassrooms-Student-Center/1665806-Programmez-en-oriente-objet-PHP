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

namespace App\Infra\MatchMaker;

use App\Domain\Exceptions\NotFoundPlayersException;
use App\Domain\MatchMaker\Lobby as BaseLobby;
use App\Domain\MatchMaker\Player\InLobbyPlayerInterface;
use App\Domain\MatchMaker\Player\PlayerInterface;
use App\Infra\MatchMaker\Storage\Repository\EncounterRepository;
use App\Infra\MatchMaker\Storage\Repository\QueuingPlayerRepository;

class Lobby extends BaseLobby
{
    public function __construct(public EncounterRepository $encounterRepository, public QueuingPlayerRepository $queuingPlayerRepository)
    {
        $this->encounters = $encounterRepository->findAll();

        $this->queuingPlayers = $queuingPlayerRepository->findAll();
        usort($this->queuingPlayers, static function (PlayerInterface $p1, PlayerInterface $p2) {
            return $p1->getRatio() <=> $p2->getRatio();
        });
    }

    public function removePlayer(PlayerInterface $player): void
    {
        try {
            $queuingPlayer = $this->isInLobby($player);
            $this->queuingPlayerRepository->remove($queuingPlayer);
            parent::removePlayer($queuingPlayer);
        } catch (NotFoundPlayersException $exception) {
            throw new \Exception('You cannot remove a player that is not in the lobby.', 128, $exception);
        }
    }

    public function addPlayer(PlayerInterface $player): void
    {
        parent::addPlayer($player);
        $this->queuingPlayerRepository->save(end($this->queuingPlayers));
    }

    public function createEncounterForPlayer(InLobbyPlayerInterface $player): void
    {
        parent::createEncounterForPlayer($player);
        $this->encounterRepository->save(end($this->encounters));
    }
}
