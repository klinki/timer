<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class TaskRepository extends EntityRepository
{
    /** @var Connection */
    protected $connection;

    /**
     * Constructor.
     *
     * @param EntityManager $em
     * @param ClassMetadata $class
     */
    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->connection = $em->getConnection();
    }

    /**
     * Gets all unfinished tasks
     *
     * @param User $user
     * @return Task[]
     */
    public function findAllUnfinishedByUser(User $user)
    {
        return $this->findBy([
            'finished' => false,
            'owner' => $user
        ]);
    }

    /**
     * Gets all user tasks 
     */
    public function findAllByUser(User $user) 
    {
        return $this->findBy([
            'owner' => $user
        ]);
    }

    /**
     * @param int $userId
     * @return Task|null
     */
    public function findUserDefaultTask($userId)
    {
        return $this->findOneBy([
            'owner' => $userId
        ]);
    }

    /**
     * Persists task
     *
     * @param Task $task
     * @return Task
     */
    public function save(Task $task)
    {
        $this->connection->beginTransaction();

        $this->_em->persist($task);
        $this->_em->flush();

        $this->_em->commit();

        return $task;
    }

    /**
     * Updates task
     *
     * @param Task $task
     * @return Task
     */
    public function update(Task $task)
    {
        $this->_em->persist($task);
        return $task;
    }

    /**
     * Deletes task
     *
     * @param Task $task
     */
    public function delete(Task $task)
    {
        $this->_em->remove($task);
    }
}
