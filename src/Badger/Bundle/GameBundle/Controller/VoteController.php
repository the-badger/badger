<?php

namespace Badger\Bundle\GameBundle\Controller;

use Badger\Bundle\GameBundle\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author  Olivier Soulet <olivier.soulet@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class VoteController extends Controller
{
    /**
     * @Route("/votable-badges", name="votable_badges")
     *
     * @return Response
     */
    public function indexAction()
    {
        $votableItems = $this->get('badger.game.repository.votable_item')
            ->findBy(['pending' => 1]);

        $votesResults = [];
        foreach ($votableItems as $votableItem) {
            $voteResult = 0;
            $votes = $votableItem->getVotes();
            foreach ($votes as $vote) {
                $voteResult += (int) $vote->getVote();
            }
            $votesResults[$votableItem->getId()] = $voteResult;
        }

        return $this->render('@Game/pending-votes.html.twig', [
            'votableItems' => $votableItems,
            'votesResults' => $votesResults
        ]);
    }

    /**
     * @Route("/pending-badge/upvote/{id}", name="badge_upvote")
     *
     * @return Response
     */
    public function upvoteAction($id)
    {
        $votableItem = $this->get('badger.game.repository.votable_item')
            ->findOneBy(['id' => $id, 'pending' => 1]);

        //TODO: to extract
        $vote = $this->get('badger.game.repository.vote')->findOneBy(
            [
                'votableItem' => $votableItem,
                'user' => $this->getUser()
            ]
        );

        if (null === $vote) {
            $vote = new Vote();
            $vote->setVotableItem($votableItem);
            $vote->setUser($this->getUser());
        }

        if (1 === $vote->getVote()) {
            $vote->setVote(0);
        } else {
            $vote->setVote(1);
        }

        $this->get('badger.game.saver.vote')->save($vote);

        if (null === $votableItem) {
            throw new NotFoundHttpException(sprintf('No pending votable entity with id %s', $id));
        }

        $this->addFlash('notice', sprintf(
            'You successfully voted for "%s" to have the badge %s!',
            $votableItem->getBadgeCompletion()->getUser()->getUsername(),
            $votableItem->getBadgeCompletion()->getBadge()->getTitle()
        ));

        return $this->redirectToRoute('votable_badges');
    }

    /**
     * @Route("/pending-badge/downvote/{id}", name="badge_downvote")
     *
     * @return Response
     */
    public function downvoteAction($id)
    {
        $votableItem = $this->get('badger.game.repository.votable_item')
            ->findOneBy(['id' => $id, 'pending' => 1]);

        //TODO: to extract
        $vote = $this->get('badger.game.repository.vote')->findOneBy(
            [
                'votableItem' => $votableItem,
                'user' => $this->getUser()
            ]
        );

        if (null === $vote) {
            $vote = new Vote();
            $vote->setVotableItem($votableItem);
            $vote->setUser($this->getUser());
        }

        if (-1 === $vote->getVote()) {
            $vote->setVote(0);
        } else {
            $vote->setVote(-1);
        }

        $this->get('badger.game.saver.vote')->save($vote);

        $this->addFlash('notice', 'You successfully voted ! "%s" to NOT have the badge %s!');

        return $this->redirectToRoute('votable_badges');
    }
}
