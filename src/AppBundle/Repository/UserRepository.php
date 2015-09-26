<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function add(User $user)
    {
        $this->getEntityManager()->persist($user);
    }

    public function remove(User $user)
    {
        $this->getEntityManager()->remove($user);
    }

    public function update(User $user)
    {
        $this->getEntityManager()->persist($user);
    }


    public function findByEmail($email)
    {
        $user = $this->findOneBy(['email' => $email]);

        if (!$user) {
            throw new EntityNotFoundException();
        }

        return $user;
    }

}