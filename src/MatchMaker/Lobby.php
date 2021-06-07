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

use App\Domain\MatchMaker\Encounter\Encounter;
use App\Domain\MatchMaker\Player\InLobbyPlayerInterface;
use App\Domain\MatchMaker\Player\PlayerInterface;
use App\Domain\MatchMaker\Player\QueuingPlayer;

class Lobby implements LobbyInterface
{
    /** @var array<QueuingPlayer> */
    public array $queuingPlayers = [];
    /** @var array<Encounter> */
    public array $encounters = [];

    /**
     * @return array<InLobbyPlayerInterface>
     */
    protected function findOponents(InLobbyPlayerInterface $player): array
    {
        $minLevel = round($player->getRatio() / 100);
        $maxLevel = $minLevel + $player->getRange();

        return array_filter($this->queuingPlayers, static function (InLobbyPlayerInterface $potentialOponent) use ($minLevel, $maxLevel, $player) {
            $playerLevel = round($potentialOponent->getRatio() / 100);

            return $player !== $potentialOponent && ($minLevel <= $playerLevel) && ($playerLevel <= $maxLevel);
        });
    }

    public function isInLobby(PlayerInterface $player): QueuingPlayer
    {
        /** @var QueuingPlayer $queuingPlayer */
        foreach ($this->queuingPlayers as $queuingPlayer) {
            // since we go by the interface we might be checking the player or the queuing player.
            if ($queuingPlayer === $player || $queuingPlayer->getPlayer() === $player) {
                return $queuingPlayer;
            }
        }

        trigger_error('Ce joueur ne se trouve pas dans le lobby', E_USER_ERROR);
    }

    public function isPlaying(PlayerInterface $player): bool
    {
        foreach ($this->encounters as $encounter) {
            if (Encounter::STATUS_OVER !== $encounter->getStatus() && ($encounter->getPlayerA() === $player || $encounter->getPlayerB() === $player)) {
                return true;
            }
        }

        return false;
    }

    public function removePlayer(PlayerInterface $player): void
    {
        $queuingPlayer = $this->isInLobby($player);

        unset($this->queuingPlayers[array_search($queuingPlayer, $this->queuingPlayers, true)]);
    }

    public function addPlayer(PlayerInterface $player): void
    {
        $this->queuingPlayers[] = new QueuingPlayer($player);
    }

    public function createEncounterForPlayer(InLobbyPlayerInterface $player): void
    {
        if (!\in_array($player, $this->queuingPlayers, true)) {
            return;
        }

        $opponents = $this->findOponents($player);

        if (empty($opponents)) {
            $player->upgradeRange();

            return;
        }

        $opponent = array_shift($opponents);

        $this->encounters[] = new Encounter(
            $player->getPlayer(),
            $opponent->getPlayer(),
        );

        $this->removePlayer($opponent);
        $this->removePlayer($player);
    }

    public function createEncounters(): void
    {
        if (2 > \count($this->queuingPlayers)) {
            trigger_error('Le nombre de joueurs est insuffisant pour créer une rencontre :(', E_USER_ERROR);
        }

        foreach ($this->queuingPlayers as $key => $player) {
            $this->createEncounterForPlayer($player);
        }
    }
}
