<?php
namespace AppBundle\Entity\Service;

use AppBundle\Entity\Repository\TaskRepository;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

class TaskService
{
    /** @var  EntityManager */
    protected $em;

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
        $this->em->beginTransaction();

        $defaultTask = $this->taskRepository->findUserDefaultTask($user->getId());
        $defaultTask->setDefault(false);
        $task->setDefault(true);
        $this->taskRepository->update($task);

        $this->em->flush();
        $this->em->commit();
    }
}
