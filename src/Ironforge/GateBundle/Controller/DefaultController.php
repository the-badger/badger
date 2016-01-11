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

        // replace this example code with whatever you need
        return $this->render('@Gate/users.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Gate/home.html.twig');
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
}
