<?php

namespace Badger\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author  Adrien Pétremann <hello@grena.fr>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class AdventureStepCompletionController extends Controller
{
    /**
     * Lists all pending adventure step completions.
     *
     * @return Response
     */
    public function indexAction()
    {
        $pendingCompletions = $this->get('badger.game.repository.adventure_step_completion')
            ->findBy(['pending' => 1]);

        return $this->render('@Game/claimed-adventure-steps/index.html.twig', [
            'pendingCompletions' => $pendingCompletions
        ]);
    }

    /**
     * Reject an adventure step completion by removing it from the database.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function rejectAction($id)
    {
        $pendingCompletion = $this->get('badger.game.repository.adventure_step_completion')
            ->findOneBy(['id' => $id, 'pending' => 1]);

        if (null === $pendingCompletion) {
            throw new NotFoundHttpException(sprintf('No pending AdventureStepCompletion entity with id %s', $id));
        }

        $stepTitle = $pendingCompletion->getAdventureStep()->getTitle();
        $username = $pendingCompletion->getUser()->getUsername();

        $questCompletionRemover = $this->get('badger.game.remover.adventure_step_completion');
        $questCompletionRemover->remove($pendingCompletion);

        $this->addFlash('notice', sprintf(
            'Successfully rejected the claimed adventure step "%s" for %s!',
            $stepTitle,
            $username
        ));

        return $this->redirectToRoute('admin_claimed_adventure_step_index');
    }

    /**
     * Accept an adventure step completion.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function acceptAction($id)
    {
        $pendingCompletion = $this->get('badger.game.repository.adventure_step_completion')
            ->findOneBy(['id' => $id, 'pending' => 1]);

        if (null === $pendingCompletion) {
            throw new NotFoundHttpException(sprintf('No pending AdventureStepCompletion entity with id %s', $id));
        }

        $user = $pendingCompletion->getUser();
        $step = $pendingCompletion->getAdventureStep();
        $adventure = $step->getAdventure();

        $pendingCompletion->setPending(false);
        $pendingCompletion->setCompletionDate(new \DateTime());

        $errors = $this->get('validator')->validate($pendingCompletion);

        if (0 === count($errors)) {
            $stepBadge = $step->getBadge();
            if (null !== $stepBadge) {
                $this->get('badger.game.unlocker.badge')->unlockBadge($user, $stepBadge);
            }

            $this->addFlash('notice', sprintf(
                '%s successfully completed the step "%s"!',
                $user->getUsername(),
                $step->getTitle()
            ));

            $user->addNuts($step->getRewardPoint());
            $this->get('badger.game.saver.adventure_step_completion')->save($pendingCompletion);

            // Check if adventure is complete
            $completedSteps = count($this->get('badger.game.repository.adventure_step_completion')
                ->userAdventureCompletedSteps($user, $adventure));
            $totalStep = count($adventure->getSteps());

            if ($completedSteps === $totalStep) {
                $user->addNuts($adventure->getRewardPoint());

                $adventureBadge = $adventure->getBadge();
                if (null !== $adventureBadge) {
                    $this->get('badger.game.unlocker.badge')->unlockBadge($user, $adventureBadge);
                }
            }
        } else {
            $this->addFlash('error', (string) $errors);
        }

        return $this->redirectToRoute('admin_claimed_adventure_step_index');
    }
}
