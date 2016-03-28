<?php

namespace Ironforge\GateBundle\Controller;

use Ironforge\AchievementBundle\Entity\ClaimedBadge;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $lastUnlockedBadges = $this->get('ironforge.achievement.repository.unlocked_badge')->findBy(
            [],
            ['unlockedDate' => 'DESC'],
            15
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
        $badgesCount = $this->get('ironforge.achievement.repository.badge')->countAll();
        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneBy([
            'username' => $username
        ]);

        $unlockedBadges = [];
        $percentUnlock = 0;

        if ($user) {
            $unlockedBadges = $this->get('ironforge.achievement.repository.unlocked_badge')->findBy([
                'user' => $user
            ]);

            if ($unlockedBadges) {
                $percentUnlock = ceil(100 * count($unlockedBadges) / $badgesCount);
            }
        }

        return $this->render('@Gate/user-profile.html.twig', [
            'user'           => $user,
            'unlockedBadges' => $unlockedBadges,
            'percentUnlock'  => $percentUnlock,
            'badgesCount'    => $badgesCount
        ]);
    }

    /**
     * @Route("/badge/{id}", name="viewbadge")
     */
    public function badgeViewAction(Request $request, $id)
    {
        $badge = $this->get('ironforge.achievement.repository.badge')->findOneBy([
            'id' => $id
        ]);

        if (null === $badge) {
            throw $this->createNotFoundException();
        }

        $user = $this->getUser();
        $usersCount = $this->getDoctrine()->getRepository('UserBundle:User')->countAll();
        $percentUnlock = 0;

        $unlockedBadges = $this->get('ironforge.achievement.repository.unlocked_badge')->findBy([
            'badge' => $badge
        ]);

        $isUnlocked = array_filter($unlockedBadges, function ($unlock) use ($user) {
            return $unlock->getUser()->getId() === $user->getId();
        });

        $isClaimed = null !== $this->get('ironforge.achievement.repository.claimed_badge')->findOneBy([
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
        $badge = $this->get('ironforge.achievement.repository.badge')->find($id);

        if (null === $badge) {
            return new JsonResponse('No badge with this id.', 400);
        }

        $claimedBadge = $this->get('ironforge.achievement.repository.claimed_badge')->findOneBy([
            'user' => $user,
            'badge' => $badge
        ]);

        if (null !== $claimedBadge) {
            return new JsonResponse('This badge is already claimed.', 400);
        }

        $claimedBadgeFactory = $this->get('ironforge.achievement.claimed_badge.factory');
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

        $unlockedBadgeIds = $this->get('ironforge.achievement.repository.unlocked_badge')
            ->getUnlockedBadgeIdsByUser($user);

        $claimedBadgeIds = $this->get('ironforge.achievement.repository.claimed_badge')
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
