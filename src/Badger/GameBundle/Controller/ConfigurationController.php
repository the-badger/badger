<?php

namespace Badger\GameBundle\Controller;

use Badger\GameBundle\Form\ConfigurationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class ConfigurationController extends Controller
{
    /**
     * Lists all Configuration.
     *
     * @return Response
     */
    public function indexAction()
    {
        $badges = $this->get('badger.game.repository.configuration')
            ->findAll();

        return $this->render('@Game/configuration/index.html.twig', [
            'configurations' => $badges,
        ]);
    }

    /**
     * Creates or edits an Configuration entity.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return RedirectResponse|Response
     */
    public function formAction(Request $request, $id)
    {
        $configuration = $this->get('badger.game.repository.configuration')->find($id);
        if (null === $configuration) {
            $configuration = $this->get('badger.game.configuration.factory')->create();
        }

        $form = $this->createForm(new ConfigurationType(), $configuration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('badger.game.saver.configuration')->save($configuration);

            return $this->redirectToRoute('admin_configuration_index');
         }

        return $this->render('@Game/configuration/form.html.twig', [
            'badge' => $configuration,
            'form'  => $form->createView()
        ]);
     }
}
