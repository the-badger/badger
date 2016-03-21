<?php

namespace Ironforge\TagBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ironforge\TagBundle\Entity\Tag;
use Ironforge\TagBundle\Form\TagType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tag controller.
 *
 */
class TagController extends Controller
{
    /**
     * Lists all Tag entities.
     */
    public function indexAction()
    {
        $tags = $this->get('ironforge.tag.repository.tag')
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
        $tagFactory = $this->get('ironforge.tags.tag.factory');
        $tag = $tagFactory->create();

        $form = $this->createForm('Ironforge\TagBundle\Form\TagType', $tag);
        $form->remove('createdAt');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagSaver = $this->get('ironforge.tags.saver.tag');
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
     */
    public function editAction(Request $request, Tag $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);
        $editForm = $this->createForm('Ironforge\TagBundle\Form\TagType', $tag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            return $this->redirectToRoute('admin_tag_edit', ['id' => $tag->getId()]);
        }

        return $this->render('@Tag/tag/edit.html.twig', [
            'tag' => $tag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Tag entity.
     *
     */
    public function deleteAction(Request $request, Tag $tag)
    {
        $form = $this->createDeleteForm($tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();
        }

        return $this->redirectToRoute('admin_tag_index');
    }

    /**
     * Creates a form to delete a Tag entity.
     *
     * @param Tag $tag The Tag entity
     *
     * @return \Symfony\Component\Form\Form The form
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
