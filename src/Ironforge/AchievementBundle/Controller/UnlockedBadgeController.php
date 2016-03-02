<?php

namespace Ironforge\AchievementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Unlocked Badge controller for admin CRUD.
 *
 * @author Adrien Pétremann <adrien.petremann@akeneo.com>
 */
class UnlockedBadgeController extends Controller
{
    /**
     * Creates a new UnlockedBadge entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        if ('POST' === $request->getMethod()) {
            $validator = $this->get('validator');

            $user = $this->container->get('fos_user.user_manager')->findUserByUsername($request->get('user'));
            $badge = $em->getRepository('AchievementBundle:Badge')->findOneById($request->get('badge'));

            $isUnlocked = $em->getRepository('AchievementBundle:UnlockedBadge')->findOneBy([
                'user' => $user,
                'badge' => $badge
            ]);

            if ($isUnlocked) {
                $this->addFlash('error', sprintf('%s already has the badge "%s"',
                    $user->getUsername(),
                    $badge->getTitle()
                ));

                return $this->redirectToRoute('admin_unlocked_badge_new');
            }

            $unlockedBadgeFactory = $this->get('ironforge.achievement.unlocked_badge.factory');
            $unlockedBadge = $unlockedBadgeFactory->create($user, $badge);

            $errors = $validator->validate($unlockedBadge);

            if (0 === count($errors)) {
                $unlockedBadgeSaver = $this->get('ironforge.achievements.saver.unlocked_badge');
                $unlockedBadgeSaver->save($unlockedBadge);

                $this->addFlash('notice', sprintf(
                    '%s successfully received the badge "%s"!',
                    $user->getUsername(),
                    $badge->getTitle()
                ));
            } else {
                $this->addFlash('error', (string) $errors);
            }
        }

        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $badges = $em->getRepository('AchievementBundle:Badge')->findAll();
        $badges = $serializer->serialize($badges, 'json');

        $users = $this->container->get('fos_user.user_manager')->findUsers();
        $usernames = [];
        foreach ($users as $user) {
            $usernames[] = $user->getUsername();
        }
        $usernames = $serializer->serialize($usernames, 'json');

        return $this->render('@Achievement/unlocked-badges/new.html.twig', [
            'badges' => $badges,
            'users' => $usernames
        ]);
    }

    /**
     * Deletes an UnlockedBadge entity.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function deleteAction(Request $request)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        if ('POST' === $request->getMethod()) {
            $user = $this->container->get('fos_user.user_manager')->findUserByUsername($request->get('user'));
            $badge = $em->getRepository('AchievementBundle:Badge')->findOneById($request->get('badge'));

            $unlocked = $em->getRepository('AchievementBundle:UnlockedBadge')->findOneBy([
                'user' => $user,
                'badge' => $badge
            ]);

            if (null === $unlocked) {
                $this->addFlash('error', sprintf('%s has no badge named "%s"', $user->getUsername(), $badge->getTitle()));

                return $this->redirectToRoute('admin_unlocked_badge_delete');
            }

            $em->remove($unlocked);
            $em->flush();

            $this->addFlash('notice', sprintf(
                'Successfully removed the badge "%s" to the user "%s"!',
                $badge->getTitle(),
                $user->getUsername()
            ));
        }

        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $badges = $em->getRepository('AchievementBundle:Badge')->findAll();
        $badges = $serializer->serialize($badges, 'json');

        $users = $this->container->get('fos_user.user_manager')->findUsers();
        $usernames = [];
        foreach ($users as $user) {
            $usernames[] = $user->getUsername();
        }
        $usernames = $serializer->serialize($usernames, 'json');

        return $this->render('@Achievement/unlocked-badges/remove.html.twig', [
            'badges' => $badges,
            'users' => $usernames
        ]);
    }
}
