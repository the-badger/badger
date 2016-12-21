<?php

namespace Badger\Bundle\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class ClaimedBadgeController extends Controller
{
    /**
     * Lists all ClaimedBadge entities.
     *
     * @return Response
     */
    public function indexAction()
    {
        $claimedBadges = $this->get('badger.game.repository.claimed_badge')
            ->findAll();

        return $this->render('@Game/claimed-badges/index.html.twig', [
            'claimedBadges' => $claimedBadges
        ]);
    }

    /**
     * Reject a claimed badge by removing it from the database.
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function rejectAction($id)
    {
        $claimedBadge = $this->get('badger.game.repository.claimed_badge')
            ->find($id);

        if (null === $claimedBadge) {
            throw new \LogicException(sprintf('No ClaimedBadge entity with id %s', $id));
        }

        $badgeTitle = $claimedBadge->getBadge()->getTitle();
        $username = $claimedBadge->getUser()->getUsername();

        $claimedBadgeRemover = $this->get('badger.game.remover.claimed_badge');
        $claimedBadgeRemover->remove($claimedBadge);

        $this->addFlash('notice', sprintf(
            'Successfully rejected the badge "%s" for %s!',
            $badgeTitle,
            $username
        ));

        return $this->redirectToRoute('admin_claimed_badge_index');
    }

    /**
     * Accept a claimed badge by creating a new unlocked badge.
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function acceptAction($id)
    {
        $claimedBadge = $this->get('badger.game.repository.claimed_badge')
            ->find($id);

        if (null === $claimedBadge) {
            throw new \LogicException(sprintf('No ClaimedBadge entity with id %s', $id));
        }

        $user = $claimedBadge->getUser();
        $badge = $claimedBadge->getBadge();

        $isUnlocked = $this->get('badger.game.repository.unlocked_badge')
            ->findOneBy([
                'user' => $user,
                'badge' => $badge
            ]);

        if ($isUnlocked) {
            $this->addFlash('error', sprintf('%s already has the badge "%s"',
                $user->getUsername(),
                $badge->getTitle()
            ));

            return $this->redirectToRoute('admin_claimed_badge_index');
        }

        $validator = $this->get('validator');

        $unlockedBadgeFactory = $this->get('badger.game.unlocked_badge.factory');
        $unlockedBadge = $unlockedBadgeFactory->create($user, $badge);

        $errors = $validator->validate($unlockedBadge);

        if (0 === count($errors)) {
            $unlockedBadgeSaver = $this->get('badger.game.saver.unlocked_badge');
            $claimedBadgeRemover = $this->get('badger.game.remover.claimed_badge');

            $unlockedBadgeSaver->save($unlockedBadge);
            $claimedBadgeRemover->remove($claimedBadge);

            $this->addFlash('notice', sprintf(
                '%s successfully received the badge "%s"!',
                $user->getUsername(),
                $badge->getTitle()
            ));
        } else {
            $this->addFlash('error', (string) $errors);
        }

        return $this->redirectToRoute('admin_claimed_badge_index');
    }
}
