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
        $lastUnlockedBadges = $this->getDoctrine()->getRepository('AchievementBundle:UnlockedBadge')->findBy(
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
        $badgesCount = $this->getDoctrine()->getRepository('AchievementBundle:Badge')->countAll();
        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneBy([
            'username' => $username
        ]);

        $unlockedBadges = [];
        $percentUnlock = 0;

        if ($user) {
            $unlockedBadges = $this->getDoctrine()->getRepository('AchievementBundle:UnlockedBadge')->findBy([
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
        $badge = $this->getDoctrine()->getRepository('AchievementBundle:Badge')->findOneBy([
            'id' => $id
        ]);

        if (null === $badge) {
            throw $this->createNotFoundException();
        }

        $user = $this->getUser();
        $usersCount = $this->getDoctrine()->getRepository('UserBundle:User')->countAll();
        $percentUnlock = 0;

        $unlockedBadges = $this->getDoctrine()->getRepository('AchievementBundle:UnlockedBadge')->findBy([
            'badge' => $badge
        ]);

        $isUnlocked = array_filter($unlockedBadges, function ($unlock) use ($user) {
            return $unlock->getUser()->getId() === $user->getId();
        });

        $isClaimed = null !== $this->getDoctrine()->getRepository('AchievementBundle:ClaimedBadge')->findOneBy([
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
        $badge = $this->getDoctrine()->getRepository('AchievementBundle:Badge')->find($id);

        if (null === $badge) {
            return new JsonResponse('No badge with this id.', 400);
        }

        $claimedBadge = $this->getDoctrine()->getRepository('AchievementBundle:ClaimedBadge')->findOneBy([
            'user' => $user,
            'badge' => $badge
        ]);

        if (null !== $claimedBadge) {
            return new JsonResponse('This badge is already claimed.', 400);
        }

        $claimedBadge = new ClaimedBadge();
        $claimedBadge->setBadge($badge);
        $claimedBadge->setUser($user);
        $claimedBadge->setClaimedDate(new \DateTime());

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
        $badges = $this->getDoctrine()->getRepository('AchievementBundle:Badge')->findAll();
        $user = $this->getUser();

        $unlockedBadgeIds = $this->getDoctrine()->getRepository('AchievementBundle:UnlockedBadge')
            ->getUnlockedBadgeIdsByUser($user);

        $claimedBadgeIds = $this->getDoctrine()->getRepository('AchievementBundle:ClaimedBadge')
            ->getBadgeIdsClaimedByUser($user);

        return $this->render('@Gate/badges.html.twig', [
            'badges' => $badges,
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
