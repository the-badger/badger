<?php

namespace Ironforge\GateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $user = $this->getUser();
        $usersCount = $this->getDoctrine()->getRepository('UserBundle:User')->countAll();
        $badge = $this->getDoctrine()->getRepository('AchievementBundle:Badge')->findOneBy([
            'id' => $id
        ]);

        $unlockedBadges = [];
        $isUnlocked = false;
        $percentUnlock = 0;

        if ($badge) {
            $unlockedBadges = $this->getDoctrine()->getRepository('AchievementBundle:UnlockedBadge')->findBy([
                'badge' => $badge
            ]);

            $isUnlocked = array_filter($unlockedBadges, function ($unlock) use ($user) {
                return $unlock->getUser()->getId() === $user->getId();
            });

            if ($unlockedBadges) {
                $percentUnlock = ceil(100 * count($unlockedBadges) / $usersCount);
            }
        }

        return $this->render('@Gate/view-badge.html.twig', [
            'badge'          => $badge,
            'unlockedBadges' => $unlockedBadges,
            'isUnlocked'     => $isUnlocked,
            'percentUnlock'  => $percentUnlock
        ]);
    }

    /**
     * @Route("/badges", name="badges")
     */
    public function badgeListAction(Request $request)
    {
        $badges = $this->getDoctrine()->getRepository('AchievementBundle:Badge')->findAll();
        $unlockedBadges = $this->getDoctrine()->getRepository('AchievementBundle:UnlockedBadge')
            ->getUserUnlockedBadges($this->getUser());

        return $this->render('@Gate/badges.html.twig', [
            'badges' => $badges,
            'unlockedBadges' => $unlockedBadges
        ]);
    }
}
