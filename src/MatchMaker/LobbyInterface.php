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

namespace App\MatchMaker;

use App\Domain\MatchMaker\Player\PlayerInterface;

interface LobbyInterface
{
    public function isPlaying(PlayerInterface $player): bool;

    public function addPlayer(PlayerInterface $player): void;
}
