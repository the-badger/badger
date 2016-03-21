<?php

namespace Ironforge\TagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TagBundle:Default:index.html.twig');
    }
}
