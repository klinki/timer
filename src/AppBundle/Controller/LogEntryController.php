<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Repository\LogEntryRepository;
use AppBundle\Entity\Repository\TaskRepository;
use AppBundle\Entity\Service\LogEntryService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LogEntryController extends Controller
{
    /**
     * @var TaskRepository
     * @inject
     */
    protected $taskRepository;

    /**
     * @var LogEntryRepository
     * @inject
     */
    protected $logEntryRepository;

    /** @var  LogEntryService @inject */
    protected $logEntryService;

    public function indexAction()
    {
        return $this->render('', []);
    }

    public function startAction()
    {
        $user = $this->getUser();
        $logEntry = $this->logEntryService->createLogEntry($user);
        $this->logEntryService->startLogEntry($user, $logEntry);
    }

    public function stopAction()
    {

    }
}
