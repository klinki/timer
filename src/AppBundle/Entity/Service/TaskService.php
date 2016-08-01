<?php
namespace AppBundle\Entity\Service;

use AppBundle\Entity\Repository\TaskRepository;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\DBAL\Connection;

class TaskService
{
    /** @var  Connection */
    protected $connection;

    /** @var  TaskRepository */
    protected $taskRepository;

    /**
     * Sets task as users default task
     *
     * @param Task $task
     * @param User $user
     */
    public function setTaskAsDefault(Task $task, User $user)
    {
        $this->connection->beginTransaction();

        $defaultTask = $this->taskRepository->findUserDefaultTask($user->getId());
        $defaultTask->setDefault(false);
        $task->setDefault(true);
        $this->taskRepository->update($task);

        // flush should go here
        $this->connection->commit();
    }
}
