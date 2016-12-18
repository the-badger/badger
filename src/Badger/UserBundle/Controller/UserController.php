<?php

namespace Badger\UserBundle\Controller;

use Badger\UserBundle\Entity\User;
use Badger\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     */
    public function indexAction()
    {
        $users = $this->get('badger.user.repository.user')
            ->findAll();

        return $this->render('@User/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * Finds and displays a User entity.
     *
     * @param string $id
     *
     * @return Response
     */
    public function showAction($id)
    {
        $user = $this->get('badger.user.repository.user')->find($id);
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('@User/user/show.html.twig', [
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $user = $this->get('badger.user.repository.user')->find($id);
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('Badger\UserBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $userSaver = $this->get('badger.user.saver.user');
            $userSaver->save($user);

            return $this->redirectToRoute('admin_user_edit', ['id' => $user->getId()]);
        }

        return $this->render('@User/user/edit.html.twig', [
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a User entity.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $user = $this->get('badger.user.repository.user')->find($id);
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRemover = $this->get('badger.user.remover.user');
            $userRemover->remove($user);
        }

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_user_delete', ['id' => $user->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
