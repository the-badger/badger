<?php

namespace Badger\Bundle\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @author  Adrien Pétremann <adrien.petremann@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class BadgeCompletionController extends Controller
{
    /**
     * Lists all pending badge completions.
     *
     * @return Response
     */
    public function indexAction()
    {
        $pendingCompletions = $this->get('badger.game.repository.badge_completion')
            ->findBy(['pending' => 1]);

        return $this->render('@Game/claimed-badges/index.html.twig', [
            'pendingCompletions' => $pendingCompletions
        ]);
    }

    /**
     * Reject a badge completion by removing it from the database.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function rejectAction($id)
    {
        $pendingCompletion = $this->get('badger.game.repository.badge_completion')
            ->findOneBy(['id' => $id, 'pending' => 1]);

        if (null === $pendingCompletion) {
            throw new NotFoundHttpException(sprintf('No pending BadgeCompletion entity with id %s', $id));
        }

        $badgeTitle = $pendingCompletion->getBadge()->getTitle();
        $username = $pendingCompletion->getUser()->getUsername();

        $badgeCompletionRemover = $this->get('badger.game.remover.badge_completion');
        $badgeCompletionRemover->remove($pendingCompletion);

        $this->addFlash('notice', sprintf(
            'Successfully rejected the claimed badge "%s" for %s!',
            $badgeTitle,
            $username
        ));

        return $this->redirectToRoute('admin_claimed_badge_index');
    }

    /**
     * Accept a badge completion.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function acceptAction($id)
    {
        $pendingCompletion = $this->get('badger.game.repository.badge_completion')
            ->findOneBy(['id' => $id, 'pending' => 1]);

        if (null === $pendingCompletion) {
            throw new NotFoundHttpException(sprintf('No pending BadgeCompletion entity with id %s', $id));
        }

        $user = $pendingCompletion->getUser();
        $badge = $pendingCompletion->getBadge();

        $pendingCompletion->setPending(false);
        $pendingCompletion->setCompletionDate(new \DateTime());

        $errors = $this->get('validator')->validate($pendingCompletion);

        if (0 === count($errors)) {
            $this->get('badger.game.saver.badge_completion')->save($pendingCompletion);

            $this->addFlash('notice', sprintf(
                '%s successfully unlocked the badge "%s"!',
                $user->getUsername(),
                $badge->getTitle()
            ));
        } else {
            $this->addFlash('error', (string) $errors);
        }

        return $this->redirectToRoute('admin_claimed_badge_index');
    }

    /**
     * Give a badge to a user directly by creating a completed badge completion.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function giveAction(Request $request)
    {
        $badgeRepository = $this->get('badger.game.repository.badge');

        if ('POST' === $request->getMethod()) {
            $validator = $this->get('validator');

            $user = $this->get('fos_user.user_manager')->findUserByUsername($request->get('user'));
            $badge = $badgeRepository->find($request->get('badge'));

            $token = new UsernamePasswordToken($user, 'none', 'none', $user->getRoles());
            $isUnlockable = $this->get('security.access.public_decision_manager')->decide($token, ['view'], $badge);

            if (!$isUnlockable) {
                $this->addFlash('error', sprintf('%s does not have access to badge "%s"',
                    $user->getUsername(),
                    $badge->getTitle()
                ));

                return $this->redirectToRoute('admin_unlocked_badge_give');
            }

            $badgeCompletion = $this->get('badger.game.repository.badge_completion')
                ->findOneBy([
                    'user' => $user,
                    'badge' => $badge
                ]);

            if (null === $badgeCompletion) {
                $badgeCompletion = $this->get('badger.game.badge_completion.factory')
                    ->create($user, $badge);
            }

            if (!$badgeCompletion->isPending()) {
                $this->addFlash('error', sprintf('%s already has the badge "%s"',
                    $user->getUsername(),
                    $badge->getTitle()
                ));

                return $this->redirectToRoute('admin_unlocked_badge_give');
            }

            $badgeCompletion->setPending(false);
            $badgeCompletion->setCompletionDate(new \DateTime());

            $errors = $validator->validate($badgeCompletion);

            if (0 === count($errors)) {
                $this->get('badger.game.saver.badge_completion')->save($badgeCompletion);

                $this->addFlash('notice', sprintf(
                    '%s successfully received the badge "%s"!',
                    $user->getUsername(),
                    $badge->getTitle()
                ));
            } else {
                $this->addFlash('error', (string) $errors);
            }
        }

        $badges = $badgeRepository->findAll();
        $usernames = $this->get('badger.user.repository.user')->getAllUsernames();

        return $this->render('@Game/unlocked-badges/give.html.twig', [
            'badges' => json_encode($badges),
            'users'  => json_encode($usernames)
        ]);
    }

    /**
     * Remove a badge from a user by removing the badge completion.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function removeAction(Request $request)
    {
        $badgeRepository = $this->get('badger.game.repository.badge');

        if ('POST' === $request->getMethod()) {
            $user = $this->container->get('fos_user.user_manager')->findUserByUsername($request->get('user'));
            $badge = $badgeRepository->findOneById($request->get('badge'));

            $badgeCompletion = $this->get('badger.game.repository.badge_completion')
                ->findOneBy([
                    'user' => $user,
                    'badge' => $badge,
                    'pending' => false
                ]);

            if (null === $badgeCompletion) {
                $this->addFlash('error', sprintf('%s has no badge named "%s"', $user->getUsername(), $badge->getTitle()));

                return $this->redirectToRoute('admin_unlocked_badge_remove');
            }

            $badgeCompletionRemover = $this->get('badger.game.remover.badge_completion');
            $badgeCompletionRemover->remove($badgeCompletion);

            $this->addFlash('notice', sprintf(
                'Successfully removed the badge "%s" to the user "%s"!',
                $badge->getTitle(),
                $user->getUsername()
            ));
        }

        $badges = $badgeRepository->findAll();
        $usernames = $this->get('badger.user.repository.user')->getAllUsernames();

        return $this->render('@Game/unlocked-badges/remove.html.twig', [
            'badges' => json_encode($badges),
            'users'  => json_encode($usernames)
        ]);
    }
}
