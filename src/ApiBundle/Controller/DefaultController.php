<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        return $this->render('ApiBundle:Default:index.html.twig');
    }

    /**
     * @Route("/start")
     */
    public function startAction()
    {}

    /**
     * @Route("/stop")
     */
    public function stopAction()
    {}
}
