<?php

namespace Badger\GameBundle\Controller;

use Badger\GameBundle\Form\BadgeProposalType;
use Badger\GateBundle\Controller\DefaultController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for BadgeProposal
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeProposalController extends DefaultController
{
    /**
     * Show the list of badge proposals
     * TODO Sort it!
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $badgeProposals = $this->get('badger.game.repository.badge_proposal')->findAllForIndex();
        $badgeVotes = $this->get('badger.game.repository.badge_vote')->findBy(['user' => $this->getUser()]);

        return $this->render('@Game/badge-proposals/index.html.twig', [
            'badgeProposals' => $badgeProposals,
            'badgeVotes'     => $badgeVotes
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $badgeProposalFactory = $this->get('badger.game.badge_proposal.factory');
        $badgeProposal = $badgeProposalFactory->create();
        $badgeProposal->setUser($this->getUser());

        $form = $this->createForm(new BadgeProposalType(), $badgeProposal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $badgeProposalSaver = $this->get('badger.game.saver.badge_proposal');
            $badgeProposalSaver->save($badgeProposal);

            return $this->redirectToRoute('badge_proposal_index', ['id' => $badgeProposal->getId()]);
        }

        return $this->render('@Game/badge-proposals/new.html.twig', [
            'badgeProposal' => $badgeProposal,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function toggleUpvoteAction(Request $request)
    {
        return $this->vote($request, true);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function toggleDownvoteAction(Request $request)
    {
        return $this->vote($request, false);
    }

    /**
     * @param Request $request
     * @param bool    $upOrDown
     *
     * @return Response
     */
    protected function vote(Request $request, $upOrDown)
    {
        $badgeProposalRepository = $this->get('badger.game.repository.badge_proposal');
        $badgeVoteRepository     = $this->get('badger.game.repository.badge_vote');
        $badgeVoteEngine         = $this->get('badger.game.helper.badge_vote_engine');

        $badgeProposal = $badgeProposalRepository->find($request->get('badgeProposalId'));
        $user          = $this->getUser();

        if ($upOrDown) {
            $badgeVoteEngine->toggleUpvote($user, $badgeProposal);
        } else {
            $badgeVoteEngine->toggleDownvote($user, $badgeProposal);
        }

        return JsonResponse::create([
            'upvotes'   => $badgeVoteRepository->getUpvotesCount($badgeProposal),
            'downvotes' => $badgeVoteRepository->getDownvotesCount($badgeProposal)
        ]);
    }
}
