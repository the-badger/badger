<?php

namespace Ironforge\AchievementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ironforge\AchievementBundle\Entity\Achievement;
use Ironforge\AchievementBundle\Form\AchievementType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Achievement controller.
 *
 */
class AchievementController extends Controller
{
    /**
     * Lists all Achievement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $achievements = $em->getRepository('AchievementBundle:Achievement')->findAll();

        return $this->render('@Achievement/achievement/index.html.twig', [
            'achievements' => $achievements,
        ]);
    }

    /**
     * Creates a new Achievement entity.
     *
     */
    public function newAction(Request $request)
    {
        $achievement = new Achievement();
        $form = $this->createForm(new AchievementType(), $achievement);
        $form->add('file');
        $form->remove('imagePath');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $achievement->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($achievement);
            $em->flush();

            return $this->redirectToRoute('admin_achievement_show', ['id' => $achievement->getId()]);
        }

        return $this->render('@Achievement/achievement/new.html.twig', [
            'achievement' => $achievement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Achievement entity.
     *
     */
    public function showAction(Achievement $achievement)
    {
        $deleteForm = $this->createDeleteForm($achievement);

        return $this->render('@Achievement/achievement/show.html.twig', [
            'achievement' => $achievement,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Achievement entity.
     *
     */
    public function editAction(Request $request, Achievement $achievement)
    {
        $deleteForm = $this->createDeleteForm($achievement);
        $editForm = $this->createForm(new AchievementType(), $achievement);
        $editForm->add('file');
        $editForm->remove('imagePath');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $achievement->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($achievement);
            $em->flush();

            return $this->redirectToRoute('admin_achievement_edit', ['id' => $achievement->getId()]);
        }

        return $this->render('@Achievement/achievement/edit.html.twig', [
            'achievement' => $achievement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Achievement entity.
     *
     */
    public function deleteAction(Request $request, Achievement $achievement)
    {
        $form = $this->createDeleteForm($achievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($achievement);
            $em->flush();
        }

        return $this->redirectToRoute('admin_achievement_index');
    }

    public function giveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $achievements = $em->getRepository('AchievementBundle:Achievement')->findAll();
        $achievements = $serializer->serialize($achievements, 'json');

        return $this->render('@Achievement/achievement/give.html.twig', [
            'achievements' => $achievements,
        ]);
    }

    /**
     * Creates a form to delete a Achievement entity.
     *
     * @param Achievement $achievement The Achievement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Achievement $achievement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_achievement_delete', ['id' => $achievement->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
