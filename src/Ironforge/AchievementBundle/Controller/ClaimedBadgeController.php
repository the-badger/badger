<?php

namespace Ironforge\AchievementBundle\Controller;

use Ironforge\AchievementBundle\AchievementEvents;
use Ironforge\AchievementBundle\Entity\UnlockedBadge;
use Ironforge\AchievementBundle\Event\BadgeUnlockEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class ClaimedBadgeController extends Controller
{
    public function indexAction()
    {
        $claimedBadges = $this->getDoctrine()->getRepository('AchievementBundle:ClaimedBadge')->findAll();

        return $this->render('@Achievement/claimed-badges/index.html.twig', [
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
        $em = $this->getDoctrine()->getManager();
        $claimedBadge = $em->getRepository('AchievementBundle:ClaimedBadge')->find($id);

        if (null === $claimedBadge) {
            throw new \LogicException(sprint('No ClaimedBadge entity with id %s', $id));
        }

        $badge = $claimedBadge->getBadge();
        $user = $claimedBadge->getUser();

        $em = $this->getDoctrine()->getManager();
        $em->remove($claimedBadge);
        $em->flush();

        $this->addFlash('notice', sprintf(
            'Successfully rejected the badge "%s" for %s!',
            $badge->getTitle(),
            $user->getUsername()
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
        $em = $this->getDoctrine()->getManager();
        $claimedBadge = $em->getRepository('AchievementBundle:ClaimedBadge')->find($id);

        if (null === $claimedBadge) {
            throw new \LogicException(sprint('No ClaimedBadge entity with id %s', $id));
        }

        $user = $claimedBadge->getUser();
        $badge = $claimedBadge->getBadge();

        $isUnlocked = $em->getRepository('AchievementBundle:UnlockedBadge')->findOneBy([
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

        $unlockedBadgeFactory = $this->get('ironforge.achievement.unlocked_badge.factory');
        $unlocked = $unlockedBadgeFactory->create($user, $badge);

        $errors = $validator->validate($unlocked);

        if (0 === count($errors)) {
            $em->remove($claimedBadge);
            $em->persist($unlocked);
            $em->flush();

            $event = new BadgeUnlockEvent($unlocked);
            $this->container->get('event_dispatcher')->dispatch(AchievementEvents::USER_UNLOCKS_BADGE, $event);

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
