<?php

namespace Badger\Bundle\TagBundle\Controller;

use Badger\Bundle\TagBundle\Entity\Tag;
use Badger\Bundle\TagBundle\Form\TagType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tag controller.
 *
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class TagController extends Controller
{
    /**
     * Lists all Tag entities.
     */
    public function indexAction()
    {
        $tags = $this->get('badger.tag.repository.tag')
            ->findAll();

        return $this->render('@Tag/tag/index.html.twig', [
            'tags' => $tags,
        ]);
    }

    /**
     * Creates a new Tag entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $tagFactory = $this->get('badger.tags.tag.factory');
        $tag = $tagFactory->create();

        $form = $this->createForm('Badger\Bundle\TagBundle\Form\TagType', $tag);
        $form->remove('createdAt');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagSaver = $this->get('badger.tags.saver.tag');
            $tagSaver->save($tag);

            return $this->redirectToRoute('admin_tag_show', ['id' => $tag->getId()]);
        }

        return $this->render('@Tag/tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Tag entity.
     *
     * @param Tag $tag
     *
     * @return Response
     */
    public function showAction(Tag $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);

        return $this->render('@Tag/tag/show.html.twig', [
            'tag' => $tag,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Tag entity.
     *
     * @param Request $request
     * @param Tag     $tag
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Tag $tag)
    {
        $editForm = $this->createForm('Badger\Bundle\TagBundle\Form\TagType', $tag);
        $editForm->remove('createdAt');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $tagSaver = $this->get('badger.tags.saver.tag');
            $tagSaver->save($tag);

            return $this->redirectToRoute('admin_tag_edit', ['id' => $tag->getId()]);
        }

        return $this->render('@Tag/tag/edit.html.twig', [
            'tag' => $tag,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a Tag entity.
     *
     * @param Request $request
     * @param Tag     $tag
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Tag $tag)
    {
        $form = $this->createDeleteForm($tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagRemover = $this->get('badger.tags.remover.tag');
            $tagRemover->remove($tag);
        }

        return $this->redirectToRoute('admin_tag_index');
    }

    /**
     * Creates a form to delete a Tag entity.
     *
     * @param Tag $tag The Tag entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Tag $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_tag_delete', ['id' => $tag->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
