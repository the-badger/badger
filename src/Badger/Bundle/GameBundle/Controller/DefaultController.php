<?php

namespace Badger\Bundle\GameBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $mostUnlockedBadges = [];
        $badgeChampions = [];
        $userBadgeCompletions = [];
        $userTags = $this->getUser()->getTags()->toArray();
        $date = new \DateTime();

        // Put default tag first
        usort($userTags, function ($a, $b) {
            if ($a->isDefault()) {
                return -1;
            } elseif ($b->isDefault()) {
                return 1;
            }

            return 0;
        });

        // Get most unlocked badges & champions per tag
        foreach ($userTags as $tag) {
            $currentUserIsChampion = false;

            $mostUnlockedBadges[$tag->getCode()] = $this->get('badger.game.repository.badge_completion')
                ->getMostUnlockedBadgesForDate($date, $tag, 5);

            $maxBadgeCompletions = $this->get('badger.game.repository.badge_completion')
                ->getTopNumberOfUnlocksForDate($date, $tag);

            $champions = $this->get('badger.user.repository.user')
                ->getMonthlyBadgeChampions($date, $tag, $maxBadgeCompletions);

            foreach ($champions as $champion) {
                if ($champion['user']->getId() === $this->getUser()->getId()) {
                    $currentUserIsChampion = true;
                }

                $badgeChampions[$tag->getCode()][$champion['badgeCompletions']][] = $champion['user'];
            }

            if (!$currentUserIsChampion) {
                $userCompletions = $this->get('badger.game.repository.badge_completion')
                    ->getTopNumberOfUnlocksForDate($date, $tag, $this->getUser());

                if (!empty($userCompletions)) {
                    $userBadgeCompletions[$tag->getCode()] = current($userCompletions)['nbCompletions'];
                }
            }
        }

        $newMembers = $this->get('badger.user.repository.user')->getNewUsersForMonth($date);

        return $this->render('@Game/home.html.twig', [
            'newMembers'           => $newMembers,
            'mostUnlockedBadges'   => $mostUnlockedBadges,
            'userTags'             => $userTags,
            'badgeChampions'       => $badgeChampions,
            'userBadgeCompletions' => $userBadgeCompletions
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function usersAction()
    {
        $users = $this->getDoctrine()->getRepository('UserBundle:User')->findAll();

        return $this->render('@Game/users.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        return $this->render('@Game/base-admin.html.twig');
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

        $badgeCompletions = [];

        if ($user) {
            $badgeCompletions = $this->get('badger.game.repository.badge_completion')->findBy([
                'user' => $user, 'pending' => '0'
            ]);

            foreach ($badgeCompletions as $key => $badgeCompletion) {
                if (!$this->get('security.authorization_checker')->isGranted('view', $badgeCompletion->getBadge())) {
                    unset($badgeCompletions[$key]);
                }
            }
        }

        $displayedTags = $user->getTags();

        foreach ($displayedTags as $key => $userTag) {
            if (!$this->get('security.authorization_checker')->isGranted('view', $userTag)) {
                unset($displayedTags[$key]);
            }
        }

        return $this->render('@Game/user-profile.html.twig', [
            'user'             => $user,
            'badgeCompletions' => $badgeCompletions
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

        if (null === $badge || !$this->get('security.authorization_checker')->isGranted('view', $badge)) {
            throw $this->createNotFoundException();
        }

        $badgeCompletions = $this->get('badger.game.repository.badge_completion')->findBy([
            'badge' => $badge,
            'pending' => '0'
        ]);

        $isUnlocked = false;
        $isClaimed = false;

        $userCompletion = $this->get('badger.game.repository.badge_completion')->findOneBy([
            'user' => $this->getUser(),
            'badge' => $badge
        ]);

        if (null !== $userCompletion) {
            $isClaimed = $userCompletion->isPending();
            $isUnlocked = !$userCompletion->isPending();
        }

        return $this->render('@Game/view-badge.html.twig', [
            'badge'            => $badge,
            'badgeCompletions' => $badgeCompletions,
            'isUnlocked'       => $isUnlocked,
            'isClaimed'        => $isClaimed
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

        $claimedBadge = $this->get('badger.game.repository.badge_completion')->findOneBy([
            'user' => $user,
            'badge' => $badge
        ]);

        if (null !== $claimedBadge) {
            return new JsonResponse('This badge is already claimed.', 400);
        }

        $badgeCompletionFactory = $this->get('badger.game.badge_completion.factory');
        $badgeCompletion = $badgeCompletionFactory->create($user, $badge);

        $this->get('badger.game.saver.badge_completion')->save($badgeCompletion);

        return new JsonResponse();
    }

    /**
     * @Route("/claim/step/{id}", name="claimstep")
     * @param int $id
     *
     * @return JsonResponse
     */
    public function claimStepAction($id)
    {
        $user = $this->getUser();
        $step = $this->get('badger.game.repository.adventure_step')->find($id);

        if (null === $step) {
            return new JsonResponse('No step with this id.', 404);
        }

        if (!$this->get('security.authorization_checker')->isGranted('view', $step->getAdventure())) {
            return new JsonResponse('No step with this id.', 404);
        }

        $stepCompletion = $this->get('badger.game.repository.adventure_step_completion')->findOneBy([
            'user' => $user,
            'step' => $step
        ]);

        if (null !== $stepCompletion) {
            return new JsonResponse('This step is already claimed.', 400);
        }

        $stepCompletionFactory = $this->get('badger.game.adventure_step_completion.factory');
        $stepCompletion = $stepCompletionFactory->create($user, $step);

        $this->get('badger.game.saver.adventure_step_completion')->save($stepCompletion);

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

        $unlockedBadgeIds = $this->get('badger.game.repository.badge_completion')
            ->getCompletionBadgesByUser($user, false);

        $claimedBadgeIds = $this->get('badger.game.repository.badge_completion')
            ->getCompletionBadgesByUser($user, true);

        return $this->render('@Game/badges.html.twig', [
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

        return $this->render('@Game/quests.html.twig', [
            'availableQuests'      => $availableQuests,
            'questCompletions'     => $questCompletions,
            'countAvailableQuests' => count($availableQuests),
            'countCompletedQuests' => count($questCompletions),
            'claimedQuestIds'      => $claimedQuestIds,
            'status'               => $status
        ]);
    }

    /**
     * @Route("/adventures", name="adventures")
     *
     * @return Response
     */
    public function adventureListAction()
    {
        $user = $this->getUser();

        $availableAdventures = $this->get('badger.game.repository.adventure')
            ->getAvailableAdventuresForUser($user);

        $completedAdventures = $this->get('badger.game.repository.adventure')
            ->getCompletedAdventuresForUser($user);

        $completedStepsByAdventure = $this->get('badger.game.repository.adventure_step_completion')
            ->userCompletedSteps($user);

        foreach ($availableAdventures as $adventure) {
            $adventure->completed = '0';

            foreach ($completedStepsByAdventure as $data) {
                if ($adventure->getId() === $data['adventure']->getId()) {
                    $adventure->completed = $data['completions'];
                }
            }
        }

        return $this->render('@Game/adventures.html.twig', [
            'availableAdventures' => $availableAdventures,
            'completedAdventures' => $completedAdventures
        ]);
    }

    /**
     * @Route("/adventures/{id}", name="viewadventure")
     *
     * @param int $id
     *
     * @return Response
     */
    public function adventureViewAction($id)
    {
        $user = $this->getUser();
        $adventure = $this->get('badger.game.repository.adventure')
            ->find($id);

        $completedSteps = $this->get('badger.game.repository.adventure_step_completion')
            ->userAdventureCompletedSteps($user, $adventure);

        $claimedSteps = $this->get('badger.game.repository.adventure_step_completion')
            ->userAdventureClaimedSteps($user, $adventure);

        $progression = count($completedSteps) * 100 / count($adventure->getSteps());

        $totalStep = count($adventure->getSteps());
        $isAdventureComplete = count($completedSteps) === $totalStep;

        return $this->render('@Game/view-adventure.html.twig', [
            'adventure' => $adventure,
            'completedSteps' => $completedSteps,
            'claimedSteps' => $claimedSteps,
            'progression' => $progression,
            'isAdventureComplete' => $isAdventureComplete
        ]);
    }

    /**
     * @Route("/leaderboard", name="leaderboard")
     *
     * @return Response
     */
    public function leaderboardAction()
    {
        $user = $this->getUser();
        $tags = $user->getTags();

        $results = [];
        foreach ($tags as $tag) {
            $results[$tag->getCode()] =
                $this->getDoctrine()->getRepository('UserBundle:User')->getSortedUserUnlockedBadgesByTag($tag);
        }

        return $this->render('@Game/leaderboard.html.twig', [
            'tags' => $tags,
            'results' => $results,
        ]);
    }

    /**
     * @Route("/search/users", name="search_users")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function searchUsersAction(Request $request)
    {
        $token = $request->get('token');

        if ('' === trim($token)) {
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

        $results = $this->get('badger.user.repository.elastic.user')->findUser($token);

        return new JsonResponse($results);
    }
}
