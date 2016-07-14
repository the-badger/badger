<?php

namespace Badger\GateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
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
    public function usersAction()
    {
        $users = $this->getDoctrine()->getRepository('UserBundle:User')->findAll();

        return $this->render('@Gate/users.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        return $this->render('@Gate/base-admin.html.twig');
    }

    /**
     * @Route("/user/{username}", name="userprofile")
     * @param string $username
     *
     * @return Response
     */
    public function userProfileAction($username)
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
     * @param $id
     *
     * @return Response
     */
    public function badgeViewAction($id)
    {
        $badge = $this->get('badger.game.repository.badge')->findOneBy([
            'id' => $id
        ]);

        if (null === $badge) {
            throw $this->createNotFoundException();
        }

        if (!$this->get('security.authorization_checker')->isGranted('view', $badge)) {
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
     * @Route("/claim/badge/{id}", name="claimbadge")
     * @param int $id
     *
     * @return JsonResponse
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
     * @Route("/claim/quest/{id}", name="claimquest")
     * @param int $id
     *
     * @return JsonResponse
     */
    public function claimQuestAction($id)
    {
        $user = $this->getUser();
        $quest = $this->get('badger.game.repository.quest')->find($id);

        if (null === $quest) {
            return new JsonResponse('No quest with this id.', 400);
        }

        if (!$this->get('security.authorization_checker')->isGranted('view', $quest)) {
            return new JsonResponse('No quest with this id.', 400);
        }

        $questCompletion = $this->get('badger.game.repository.quest_completion')->findOneBy([
            'user' => $user,
            'quest' => $quest
        ]);

        if (null !== $questCompletion) {
            return new JsonResponse('This quest is already claimed.', 400);
        }

        $questCompletionFactory = $this->get('badger.game.quest_completion.factory');
        $questCompletion = $questCompletionFactory->create($user, $quest);

        $this->get('badger.game.saver.quest_completion')->save($questCompletion);

        return new JsonResponse();
    }

    /**
     * @Route("/badges", name="badges")
     * 
     * @return Response
     */
    public function badgeListAction()
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
     * @Route("/quests", name="quests")
     * @param Request $request
     *
     * @return Response
     */
    public function questListAction(Request $request)
    {
        $user = $this->getUser();
        $status = $request->get('status', 'available');

        $questRepository = $this->get('badger.game.repository.quest');
        $completionRepository = $this->get('badger.game.repository.quest_completion');

        $availableQuests = $questRepository->getAvailableQuestsForUser($user);
        $questCompletions = $completionRepository->findBy(['user' => $user, 'pending' => 0]);
        $claimedQuestIds = $this->get('badger.game.repository.quest_completion')
            ->getQuestIdsClaimedByUser($user);

        return $this->render('@Gate/quests.html.twig', [
            'availableQuests'      => $availableQuests,
            'questCompletions'     => $questCompletions,
            'countAvailableQuests' => count($availableQuests),
            'countCompletedQuests' => count($questCompletions),
            'claimedQuestIds'      => $claimedQuestIds,
            'status'               => $status
        ]);
    }

    /**
     * @Route("/leaderboard", name="leaderboard")
     * 
     * @return Response
     */
    public function leaderboardAction()
    {
        $users = $this->getDoctrine()->getRepository('UserBundle:User')->getSortedUserByUnlockedBadges();

        return $this->render('@Gate/leaderboard.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/user/search/{token}", name="search")
     */
    public function findAction(Request $request)
    {
        $token = $request->get('token');
        $results = $this->get('badger.user.repository.elastic.user')->findUser($token);

        return new JsonResponse($results);
    }

    /**
     * @Route("/user/search/", name="emptysearch")
     */
    public function emptyFindAction(Request $request)
    {
        $users = $this->get('badger.user.repository.user')->findAll();
        $results = [];

        foreach ($users as $user) {
            $results[] = [
                'username' => $user->getUsername(),
                'profilePicture' => $user->getProfilePicture()
            ];
        }

        return new JsonResponse($results);
    }
}
