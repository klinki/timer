<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 9/21/15
 * Time: 10:39 PM
 */

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class TaskRepository extends EntityRepository
{
    protected $connection;

    public function __construct($em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->connection = $em->getConnection();
    }

    public function findAllUnfinishedByUser(User $user)
    {
        return $this->findBy([
            'finished' => false,
            'owner' => $user
        ]);
    }

    public function save(Task $task)
    {
        $this->connection->beginTransaction();

        $this->_em->persist($task);
        $this->_em->flush();

        $this->_em->commit();

        return $task;
    }

    public function update(Task $task)
    {
        $this->connection->beginTransaction();

        $this->_em->persist($task);
        $this->_em->flush();

        $this->_em->commit();

        return $task;
    }

    public function delete(Task $task)
    {
        $this->connection->beginTransaction();

        $this->_em->remove($task);
        $this->_em->flush();

        $this->connection->commit();
    }

}