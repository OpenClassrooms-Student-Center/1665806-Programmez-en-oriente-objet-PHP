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

use App\Domain\MatchMaker\Encounter\Encounter;
use App\Infra\MatchMaker\Lobby;
use App\Infra\MatchMaker\Storage\Repository\EncounterRepository;
use App\Infra\MatchMaker\UserInterface\Form\EncounterType;
use App\Infra\User\Storage\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as AccessControl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('match/maker')]
class EncounterController extends AbstractController
{
    #[Route('/', name: 'match_maker_index', methods: ['GET'])]
    #[AccessControl("is_granted('ROLE_USER')")]
    public function index(EncounterRepository $encounterRepository, Security $security, Lobby $lobby): Response
    {
        /** @var User $me */
        $me = $security->getUser();
        $player = $me->getPlayer();

        return $this->render('match_maker/index.html.twig', [
            'matches_playing' => $encounterRepository->getPlayerMatchesPlaying($player),
            'matches_over' => $encounterRepository->getPlayerMatchesOver($player),
            'queue' => \count($lobby->queuingPlayers),
        ]);
    }

    #[Route('/new', name: 'match_maker_new', methods: ['GET', 'POST'])]
    #[AccessControl("is_granted('ROLE_ADMIN')")]
    public function new(Request $request): Response
    {
        $encounter = new Encounter();
        $form = $this->createForm(EncounterType::class, $encounter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($encounter);
            $entityManager->flush();

            return $this->redirectToRoute('match_maker_index');
        }

        return $this->render('match_maker/new.html.twig', [
            'match_maker' => $encounter,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{date}/{playerA}/vs/{playerB}/score', name: 'match_maker_edit', methods: ['GET', 'POST'])]
    #[AccessControl("is_granted('ROLE_ADMIN')")]
    #[ParamConverter('encounter', options: ['mapping' => ['date' => 'dateOfEncounter', 'playerA' => 'playerA', 'playerB' => 'playerB']])]
    public function edit(Request $request, Encounter $encounter): Response
    {
        $form = $this->createForm(EncounterType::class, $encounter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encounter->setStatus(Encounter::STATUS_OVER);
            $encounter->updateRatios();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('match_maker_index');
        }

        return $this->render('match_maker/score.html.twig', [
            'match' => $encounter,
            'form' => $form->createView(),
        ]);
    }
}
