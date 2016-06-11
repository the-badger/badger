<?php

namespace Badger\GameBundle\Controller;

use Badger\GameBundle\Entity\Adventure;
use Badger\GameBundle\Form\AdventureType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adventure controller for admin CRUD.
 */
class AdventureController extends Controller
{
    /**
     * Lists all Adventure entities.
     *
     * @return Response
     */
    public function indexAction()
    {
        $adventures = $this->get('badger.game.repository.adventure')
            ->findAll();

        return $this->render('@Game/adventures/index.html.twig', [
            'adventures' => $adventures,
        ]);
    }

    /**
     * Creates or edits an Adventure entity.
     *
     * @param Request   $request
     * @param Adventure $adventure
     *
     * @return RedirectResponse|Response
     */
    public function formAction(Request $request, Adventure $adventure = null)
    {
        if (null === $adventure) {
            $adventure = $this->get('badger.game.adventure.factory')->create();
        }

        $form = $this->createForm(new AdventureType(), $adventure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('badger.game.saver.adventure')->save($adventure);

            return $this->redirectToRoute('admin_adventure_show', ['id' => $adventure->getId()]);
        }

        return $this->render('@Game/adventures/form.html.twig', [
            'adventure' => $adventure,
            'form' => $form->createView()
        ]);
    }

    /**
     * Finds and displays a Adventure entity.
     *
     * @param Adventure $adventure
     *
     * @return Response
     */
    public function showAction(Adventure $adventure)
    {
        $deleteForm = $this->createDeleteForm($adventure);

        return $this->render('@Game/adventures/show.html.twig', [
            'adventure'   => $adventure,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Adventure entity.
     *
     * @param Request   $request
     * @param Adventure $adventure
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Adventure $adventure)
    {
        $form = $this->createDeleteForm($adventure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $badgeRemover = $this->get('badger.game.remover.adventure');
            $badgeRemover->remove($adventure);
        }

        return $this->redirectToRoute('admin_adventure_index');
    }

    /**
     * Creates a form to delete a Badge entity.
     *
     * @param Adventure $adventure The Badge entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Adventure $adventure)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_adventure_delete', ['id' => $adventure->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
