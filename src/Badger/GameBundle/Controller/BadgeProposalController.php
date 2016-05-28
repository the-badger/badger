<?php

namespace Badger\GameBundle\Controller;

use Badger\GameBundle\Form\BadgeProposalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
class BadgeProposalController extends Controller
{
    /**
     * Show the list of badge proposals
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $badgeProposalRepository = $this->get('badger.game.repository.badge_proposal');
        $badgeVoteSummaryFactory = $this->get('badger.game.badge_vote_summary.factory');
        $badgeVoteSummary = $badgeVoteSummaryFactory->create($this->getUser());

        return $this->render('@Game/badge-proposals/index.html.twig', [
            'badgeProposals'   => $badgeProposalRepository->findAllSorted(),
            'badgeVoteSummary' => $badgeVoteSummary,
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
     * @param string $id BadgeProposal id
     *
     * @return Response
     */
    public function toggleUpvoteAction($id)
    {
        return $this->vote($id, true);
    }

    /**
     * @param string $id BadgeProposal id
     *
     * @return Response
     */
    public function toggleDownvoteAction($id)
    {
        return $this->vote($id, false);
    }

    /**
     * @param string $id      BadgeProposal id
     * @param bool   $opinion
     *
     * @return Response
     */
    protected function vote($id, $opinion)
    {
        $badgeProposalRepository = $this->get('badger.game.repository.badge_proposal');
        $badgeVoteEngine         = $this->get('badger.game.helper.badge_vote_engine');

        $badgeProposal = $badgeProposalRepository->find($id);
        $user          = $this->getUser();

        $badgeVoteEngine->toggleVote($user, $badgeProposal, $opinion);

        return JsonResponse::create([ 'success' => true ]);
    }
}
