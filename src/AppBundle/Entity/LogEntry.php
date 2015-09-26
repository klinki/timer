<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LogEntry
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\LogEntryRepository")
 */
class LogEntry
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    protected $name;

    protected $from;
    protected $to;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
