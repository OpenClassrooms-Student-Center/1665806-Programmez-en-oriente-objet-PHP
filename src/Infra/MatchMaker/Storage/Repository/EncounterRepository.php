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

use App\Domain\MatchMaker\Encounter\Encounter;
use App\Domain\MatchMaker\Player\PlayerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<Encounter>
 */
class EncounterRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Encounter::class);
        $this->security = $security;
    }

    public function save(Encounter $match): void
    {
        $this->_em->persist($match);
        $this->_em->flush();
    }

    /**
     * @return iterable<Encounter>
     */
    public function getPlayerMatchesOver(PlayerInterface $player): iterable
    {
        // filtrer par l'utilisateur connecté
        $qb = $this->createQueryBuilder('m')
            ->where('m.status = :status')
            ->setParameter('status', Encounter::STATUS_OVER);

        if (!$this->security->isGranted('ROLE_ADMIN', $player)) {
            // si je suis l'un des deux joueurs
            $qb->andWhere('m.playerA = :me OR m.playerB = :me')
                ->setParameter('me', $player);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @return iterable<Encounter>
     */
    public function getPlayerMatchesPlaying(PlayerInterface $player): iterable
    {
        // filtrer par l'utilisateur connecté
        $qb = $this->createQueryBuilder('m')
            ->where('m.status = :status')
            ->setParameter('status', Encounter::STATUS_PLAYING);

        if (!$this->security->isGranted('ROLE_ADMIN', $player)) {
            // si je suis l'un des deux joueurs
            $qb->andWhere('m.playerA = :me OR m.playerB = :me')
                ->setParameter('me', $player);
        }

        return $qb->getQuery()->getResult();
    }
}
