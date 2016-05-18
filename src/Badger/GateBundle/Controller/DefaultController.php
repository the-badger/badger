<?php

namespace Badger\GateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $lastUnlockedBadges = $this->get('badger.game.repository.unlocked_badge')->findByTags(
            $this->getUser()->getTags()->toArray()
        );

        return $this->render('@Gate/home.html.twig', [
            'unlockedBadges' => $lastUnlockedBadges
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function usersAction(Request $request)
    {
        $users = $this->getDoctrine()->getRepository('UserBundle:User')->findAll();

        return $this->render('@Gate/users.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
        return $this->render('@Gate/base-admin.html.twig');
    }

    /**
     * @Route("/user/{username}", name="userprofile")
     */
    public function userProfileAction(Request $request, $username)
    {
        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneBy([
            'username' => $username
        ]);

        $unlockedBadges = [];

        if ($user) {
            $unlockedBadges = $this->get('badger.game.repository.unlocked_badge')->findBy([
                'user' => $user
            ]);

            foreach ($unlockedBadges as $key => $unlockedBadge) {
                if (!$this->get('security.authorization_checker')->isGranted('view', $unlockedBadge->getBadge())) {
                    unset($unlockedBadges[$key]);
                }
            }
        }

        $displayedTags = $user->getTags();

        foreach ($displayedTags as $key => $userTag) {
            if (!$this->get('security.authorization_checker')->isGranted('view', $userTag)) {
                unset($displayedTags[$key]);
            }
        }

        return $this->render('@Gate/user-profile.html.twig', [
            'user'           => $user,
            'unlockedBadges' => $unlockedBadges
        ]);
    }

    /**
     * @Route("/badge/{id}", name="viewbadge")
     */
    public function badgeViewAction(Request $request, $id)
    {
        $badge = $this->get('badger.game.repository.badge')->findOneBy([
            'id' => $id
        ]);

        if (!$this->get('security.authorization_checker')->isGranted('view', $badge)) {
            throw $this->createNotFoundException();
        }

        if (null === $badge) {
            throw $this->createNotFoundException();
        }

        $user = $this->getUser();
        $usersCount = $this->getDoctrine()->getRepository('UserBundle:User')->countAll();
        $percentUnlock = 0;

        $unlockedBadges = $this->get('badger.game.repository.unlocked_badge')->findBy([
            'badge' => $badge
        ]);

        $isUnlocked = array_filter($unlockedBadges, function ($unlock) use ($user) {
            return $unlock->getUser()->getId() === $user->getId();
        });

        $isClaimed = null !== $this->get('badger.game.repository.claimed_badge')->findOneBy([
            'badge' => $badge,
            'user' => $user
        ]);

        if ($unlockedBadges) {
            $percentUnlock = ceil(100 * count($unlockedBadges) / $usersCount);
        }

        return $this->render('@Gate/view-badge.html.twig', [
            'badge'          => $badge,
            'unlockedBadges' => $unlockedBadges,
            'isUnlocked'     => $isUnlocked,
            'isClaimed'      => $isClaimed,
            'percentUnlock'  => $percentUnlock
        ]);
    }

    /**
     * @Route("/claim/{id}", name="claimbadge")
     */
    public function claimBadgeAction($id)
    {
        $user = $this->getUser();
        $badge = $this->get('badger.game.repository.badge')->find($id);

        if (null === $badge) {
            return new JsonResponse('No badge with this id.', 400);
        }

        if (!$this->get('security.authorization_checker')->isGranted('view', $badge)) {
            return new JsonResponse('No badge with this id.', 400);
        }

        $claimedBadge = $this->get('badger.game.repository.claimed_badge')->findOneBy([
            'user' => $user,
            'badge' => $badge
        ]);

        if (null !== $claimedBadge) {
            return new JsonResponse('This badge is already claimed.', 400);
        }

        $claimedBadgeFactory = $this->get('badger.game.claimed_badge.factory');
        $claimedBadge = $claimedBadgeFactory->create($user, $badge);

        $em = $this->getDoctrine()->getManager();
        $em->persist($claimedBadge);
        $em->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/badges", name="badges")
     */
    public function badgeListAction(Request $request)
    {
        $user = $this->getUser();
        $userTags = $user->getTags();

        $unlockedBadgeIds = $this->get('badger.game.repository.unlocked_badge')
            ->getUnlockedBadgeIdsByUser($user);

        $claimedBadgeIds = $this->get('badger.game.repository.claimed_badge')
            ->getBadgeIdsClaimedByUser($user);

        return $this->render('@Gate/badges.html.twig', [
            'tags' => $userTags,
            'unlockedBadgesIds' => $unlockedBadgeIds,
            'claimedBadgeIds' => $claimedBadgeIds
        ]);
    }

    /**
     * @Route("/leaderboard", name="leaderboard")
     */
    public function leaderboardAction(Request $request)
    {
        $users = $this->getDoctrine()->getRepository('UserBundle:User')->getSortedUserByUnlockedBadges();

        return $this->render('@Gate/leaderboard.html.twig', [
            'users' => $users
        ]);
    }
}
