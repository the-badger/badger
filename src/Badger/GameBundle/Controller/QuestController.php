<?php

namespace Badger\GameBundle\Controller;

use Badger\GameBundle\Entity\QuestInterface;
use Badger\GameBundle\Form\QuestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Quest controller for admin CRUD.
 *
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class QuestController extends Controller
{
    /**
     * Lists all Quest entities.
     *
     * @return Response
     */
    public function indexAction()
    {
        $quests = $this->get('badger.game.repository.quest')
            ->findAll();

        return $this->render('@Game/quests/index.html.twig', [
            'quests' => $quests,
        ]);
    }

    /**
     * Creates a new Quest entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $questFactory = $this->get('badger.game.quest.factory');
        $quest = $questFactory->create();

        $form = $this->createForm(new QuestType(), $quest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questSaver = $this->get('badger.game.saver.quest');
            $questSaver->save($quest);

            return $this->redirectToRoute('admin_quest_show', ['id' => $quest->getId()]);
        }

        return $this->render('@Game/quests/new.html.twig', [
            'quest' => $quest,
            'form'  => $form->createView()
        ]);
    }

    /**
     * Finds and displays a Quest entity.
     *
     * @param QuestInterface $quest
     *
     * @return Response
     */
    public function showAction(QuestInterface $quest)
    {
        $deleteForm = $this->createDeleteForm($quest);

        return $this->render('@Game/quests/show.html.twig', [
            'quest'       => $quest,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Quest entity.
     *
     * @param Request        $request
     * @param QuestInterface $quest
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, QuestInterface $quest)
    {
        $deleteForm = $this->createDeleteForm($quest);
        $editForm = $this->createForm(new QuestType(), $quest);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $questSaver = $this->get('badger.game.saver.quest');
            $questSaver->save($quest);

            return $this->redirectToRoute('admin_badge_edit', ['id' => $quest->getId()]);
        }

        return $this->render('@Game/quests/edit.html.twig', [
            'quest'       => $quest,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Quest entity.
     *
     * @param Request        $request
     * @param QuestInterface $quest
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, QuestInterface $quest)
    {
        $form = $this->createDeleteForm($quest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questRemover = $this->get('badger.game.remover.quest');
            $questRemover->remove($quest);
        }

        return $this->redirectToRoute('admin_quest_index');
    }

    /**
     * Creates a form to delete a Quest entity.
     *
     * @param QuestInterface $quest The Quest entity
     *
     * @return Form The form
     */
    private function createDeleteForm(QuestInterface $quest)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_quest_delete', ['id' => $quest->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
