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
        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneBy([
            'username' => $username
        ]);

        $unlockedBadges = [];

        if ($user) {
            $unlockedBadges = $this->getDoctrine()->getRepository('AchievementBundle:UnlockedBadge')->findBy([
                'user' => $user
            ]);
        }

        return $this->render('@Gate/user-profile.html.twig', [
            'user' => $user,
            'unlockedBadges' => $unlockedBadges
        ]);
    }

    /**
     * @Route("/badges", name="badges")
     */
    public function badgeListAction(Request $request)
    {
        $badges = $this->getDoctrine()->getRepository('AchievementBundle:Badge')->findAll();

        return $this->render('@Gate/badges.html.twig', [
            'badges' => $badges
        ]);
    }
}
