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

namespace App\Infra\MatchMaker\Storage\Repository;

use App\Domain\MatchMaker\Player\QueuingPlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<QueuingPlayer>
 */
class QueuingPlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QueuingPlayer::class);
    }

    public function save(QueuingPlayer $player): void
    {
        $this->_em->persist($player);
        $this->_em->flush();
    }

    public function flush(): void
    {
        $this->_em->flush();
    }

    public function remove(QueuingPlayer $player): void
    {
        $this->_em->remove($player);
        $this->_em->flush();
    }
}
