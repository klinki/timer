<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\View;

/**
 * Class TasksController
 *
 * @package ApiBundle\Controller
 * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
 */
class TasksController extends FOSRestController implements ClassResourceInterface
{
   /**
    * @View(serializerGroups={"short"})
    */
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('AppBundle:Task')->findAllByUser($this->getUser());

        return $tasks;
    }

    /**
     * @View(serializerGroups={"full"})
     * @param int $id
     * @return Task
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository('AppBundle:Task')->find($id);

        if ($task === null) {
            throw $this->createNotFoundException();
        }

        return $task;
    }

    public function postAction()
    {

    }

    public function putAction()
    {

    }

    public function deleteAction()
    {

    }
}
