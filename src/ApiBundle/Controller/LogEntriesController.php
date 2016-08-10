<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\View;

class LogEntriesController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     * @View(serializerGroups={"short"})
     */
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('AppBundle:Task')->findAllByUser($this->getUser());

        return $tasks;
    }

    public function getAction($id)
    {}

    public function postAction()
    {}

    public function putAction()
    {}

    public function deleteAction()
    {}
}
