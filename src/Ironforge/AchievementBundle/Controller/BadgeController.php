<?php

namespace Ironforge\AchievementBundle\Controller;

use Ironforge\AchievementBundle\AchievementEvents;
use Ironforge\AchievementBundle\Entity\UnlockedBadge;
use Ironforge\AchievementBundle\Event\BadgeUnlockEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Ironforge\AchievementBundle\Entity\Badge;
use Ironforge\AchievementBundle\Form\BadgeType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Badge controller for admin CRUD.
 * Handles giving process too.
 */
class BadgeController extends Controller
{
    /**
     * Lists all Badge entities.
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $badges = $em->getRepository('AchievementBundle:Badge')->findAll();

        return $this->render('@Achievement/badges/index.html.twig', [
            'badges' => $badges,
        ]);
    }

    /**
     * Creates a new Badge entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $badgeFactory = $this->get('ironforge.achievement.badge.factory');
        $badge = $badgeFactory->create();

        $form = $this->createForm(new BadgeType(), $badge);
        $form->add('file', 'file', ['label' => 'Badge image']);
        $form->remove('imagePath');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $badge->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($badge);
            $em->flush();

            return $this->redirectToRoute('admin_badge_show', ['id' => $badge->getId()]);
        }

        return $this->render('@Achievement/badges/new.html.twig', [
            'badge' => $badge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Badge entity.
     *
     * @param Badge $badge
     *
     * @return Response
     */
    public function showAction(Badge $badge)
    {
        $deleteForm = $this->createDeleteForm($badge);

        return $this->render('@Achievement/badges/show.html.twig', [
            'badge' => $badge,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Badge entity.
     *
     * @param Request $request
     * @param Badge   $badge
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Badge $badge)
    {
        $deleteForm = $this->createDeleteForm($badge);
        $editForm = $this->createForm(new BadgeType(), $badge);
        $editForm->add('file');
        $editForm->remove('imagePath');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $badge->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($badge);
            $em->flush();

            return $this->redirectToRoute('admin_badge_edit', ['id' => $badge->getId()]);
        }

        return $this->render('@Achievement/badges/edit.html.twig', [
            'badge' => $badge,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Badge entity.
     *
     * @param Request $request
     * @param Badge   $badge
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Badge $badge)
    {
        $form = $this->createDeleteForm($badge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($badge);
            $em->flush();
        }

        return $this->redirectToRoute('admin_badge_index');
    }

    /**
     * Display a form to give a Badge to a User.
     *
     * @return Response
     */
    public function giveAction()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $badges = $em->getRepository('AchievementBundle:Badge')->findAll();
        $badges = $serializer->serialize($badges, 'json');

        $users = $this->container->get('fos_user.user_manager')->findUsers();
        $usernames = [];
        foreach ($users as $user) {
            $usernames[] = $user->getUsername();
        }
        $usernames = $serializer->serialize($usernames, 'json');

        return $this->render('@Achievement/badges/give.html.twig', [
            'badges' => $badges,
            'users' => $usernames
        ]);
    }

    /**
     * Give a Badge to a User.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function giveProcessAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
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

            return $this->redirectToRoute('admin_badge_give');
        }

        $unlockedBadgeFactory = $this->get('ironforge.achievement.unlocked_badge.factory');
        $unlocked = $unlockedBadgeFactory->create($user, $badge);

        $errors = $validator->validate($unlocked);

        if (0 === count($errors)) {
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

        return $this->redirectToRoute('admin_badge_give');
    }

    /**
     * Display a form to remove a Badge from a User.
     *
     * @return Response
     */
    public function removeAction()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $badges = $em->getRepository('AchievementBundle:Badge')->findAll();
        $badges = $serializer->serialize($badges, 'json');

        $users = $this->container->get('fos_user.user_manager')->findUsers();
        $usernames = [];
        foreach ($users as $user) {
            $usernames[] = $user->getUsername();
        }
        $usernames = $serializer->serialize($usernames, 'json');

        return $this->render('@Achievement/badges/remove.html.twig', [
            'badges' => $badges,
            'users' => $usernames
        ]);
    }

    /**
     * Remove a Badge from a User.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeProcessAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('fos_user.user_manager')->findUserByUsername($request->get('user'));
        $badge = $em->getRepository('AchievementBundle:Badge')->findOneById($request->get('badge'));

        $unlocked = $em->getRepository('AchievementBundle:UnlockedBadge')->findOneBy([
            'user' => $user,
            'badge' => $badge
        ]);

        if (null === $unlocked) {
            $this->addFlash('error', sprintf('%s has no badge named "%s"', $user->getUsername(), $badge->getTitle()));

            return $this->redirectToRoute('admin_badge_remove');
        }

        $em->remove($unlocked);
        $em->flush();

        $this->addFlash('notice', sprintf(
            'Successfully removed the badge "%s" to the user "%s"!',
            $badge->getTitle(),
            $user->getUsername()
        ));

        return $this->redirectToRoute('admin_badge_remove');
    }

    /**
     * Creates a form to delete a Badge entity.
     *
     * @param Badge $achievement The Badge entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Badge $achievement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_badge_delete', ['id' => $achievement->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
