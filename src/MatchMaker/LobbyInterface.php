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

namespace App\Domain\MatchMaker;

use App\Domain\MatchMaker\Player\InLobbyPlayerInterface;
use App\Domain\MatchMaker\Player\PlayerInterface;
use App\Domain\MatchMaker\Player\QueuingPlayer;

interface LobbyInterface
{
    public function isInLobby(PlayerInterface $player): QueuingPlayer;

    public function isPlaying(PlayerInterface $player): bool;

    public function removePlayer(PlayerInterface $player): void;

    public function addPlayer(PlayerInterface $player): void;

    public function createEncounterForPlayer(InLobbyPlayerInterface $player): void;

    public function createEncounters(): void;
}
