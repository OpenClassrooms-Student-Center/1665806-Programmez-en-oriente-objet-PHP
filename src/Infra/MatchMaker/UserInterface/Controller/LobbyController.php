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

namespace App\Infra\MatchMaker\UserInterface\Controller;

use App\Domain\Exceptions\NotFoundPlayersException;
use App\Infra\MatchMaker\Lobby;
use App\Infra\MatchMaker\Storage\Repository\EncounterRepository;
use App\Infra\User\Storage\Entity\User;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as AccessControl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class LobbyController extends AbstractController
{
    #[Route('/lobby', name: 'lobby')]
    #[AccessControl('is_granted("ROLE_USER")')]
    public function enterLobby(Lobby $lobby, Security $security): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        $me = $user->getPlayer();

        if ($lobby->isPlaying($me)) {
            return $this->redirectToRoute('match_maker_index');
        }

        try {
            $lobby->isInLobby($me);
        } catch (NotFoundPlayersException $exception) {
            $lobby->addPlayer($me);
        } finally {
            return $this->redirectToRoute('lobbyPending');
        }
    }

    #[Route('/lobby/pending', name: 'lobbyPending')]
    #[AccessControl('is_granted("ROLE_USER")')]
    public function pendingLobby(Lobby $lobby, Security $security, EncounterRepository $matchMakerRepository): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        $me = $user->getPlayer();

        if ($lobby->isPlaying($me)) {
            return $this->redirectToRoute('match_maker_index');
        }

        try {
            $lobby->isInLobby($me);
        } catch (NotFoundPlayersException) {
            if (!$this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('home');
            }
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('lobby/index.html.twig', [
                'queuingPlayers' => $lobby->queuingPlayers,
            ]);
        }

        if (!empty($matches = $matchMakerRepository->getPlayerMatchesPlaying($me))) {
            $this->redirectToRoute('match_maker_index');
        }

        return $this->render('lobby/index.html.twig', ['queuingPlayers' => null]);
    }

    #[Route('/lobby/exit', name: 'lobbyExit')]
    #[AccessControl('is_granted("ROLE_USER")')]
    public function exitLobby(Lobby $lobby, Security $security, LoggerInterface $logger): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        $me = $user->getPlayer();

        try {
            $lobby->removePlayer($me);
        } catch (\Exception $e) {
            $logger->warning('Attempt to remove a non queued player.');
        }

        return $this->redirectToRoute('home');
    }
}
