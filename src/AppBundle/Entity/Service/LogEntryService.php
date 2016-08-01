<?php

namespace AppBundle\Entity\Service;

use AppBundle\Entity\LogEntry;
use AppBundle\Entity\Repository\LogEntryRepository;
use AppBundle\Entity\Repository\TaskRepository;
use AppBundle\Entity\User;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

class LogEntryService
{
    /** @var  LogEntryRepository */
    protected $logEntryRepository;

    /** @var  TaskRepository */
    protected $taskRepository;

    /** @var  EntityManager */
    protected $em;

    /**
     * Constructor.
     *
     * @param LogEntryRepository $logEntryRepository
     * @param TaskRepository $taskRepository
     * @param EntityManager $em
     */
    public function __construct(
        LogEntryRepository $logEntryRepository,
        TaskRepository $taskRepository,
        EntityManager $em
    ) {
        $this->logEntryRepository = $logEntryRepository;
        $this->taskRepository = $taskRepository;
        $this->em = $em;
    }

    public function createLogEntry(User $user)
    {
        $defaultTask = $this->taskRepository->findUserDefaultTask($user->getId());

        $logEntry = new LogEntry();
        $logEntry->setTask($defaultTask);
        $logEntry->setFrom(new \DateTime());

        return $logEntry;
    }

    public function startLogEntry(User $user, LogEntry $logEntry)
    {
        $this->em->beginTransaction();
        $this->stopActiveLogEntriesByUser($user);
        $this->logEntryRepository->save($logEntry);
        $this->em->flush();
        $this->em->commit();
    }

    protected function stopActiveLogEntriesByUser(User $user)
    {
        $activeLogEntries = $this->logEntryRepository->getNonCompletedLogEntriesByUser($user->getId());

        foreach ($activeLogEntries as $activeEntry) {
            $activeEntry->setTo(new \DateTime());
            $this->logEntryRepository->save($activeEntry);
        }
    }

    public function stopLogEntry(User $user, LogEntry $logEntry)
    {
        $this->em->beginTransaction();
        $this->stopActiveLogEntriesByUser($user);
        $this->logEntryRepository->save($logEntry);
        $this->em->flush();
        $this->em->commit();
    }
}
