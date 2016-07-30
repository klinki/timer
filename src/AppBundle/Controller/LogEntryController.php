<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LogEntryController extends Controller
{
    /**
     * @var TaskRepository
     * @inject
     */
    protected $taskRepository;

    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function startAction()
    {

    }

    public function stopAction()
    {

    }
}
