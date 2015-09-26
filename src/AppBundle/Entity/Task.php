<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Task
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     *
     * @ORM\Column(name="owner", type="object")
     */
    protected $owner;


    /**
     * @ORM\ManyToOne(targetEntity="LogEntry")
     */
    protected $logEntries;


    /**
     * @ORM\Column(type="boolean")
     */
    protected $isFinished;


    /**
     * @param string $name
     * @param User $owner
     */
    public function __construct($name, User $owner)
    {
        $this->name = $name;
        $this->owner = $owner;
        $this->logEntries = [];
        $this->isFinished = false;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Task
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get owner
     *
     * @return \stdClass 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $logEntries
     */
    public function setLogEntries($logEntries)
    {
        $this->logEntries = $logEntries;
    }

    /**
     * @return mixed
     */
    public function getIsFinished()
    {
        return $this->isFinished;
    }

    /**
     * @param mixed $isFinished
     */
    public function setIsFinished($isFinished)
    {
        $this->isFinished = $isFinished;
    }

    public function addLogEntry(LogEntry $logEntry)
    {
        if ($this->isFinished) {
            throw new \RuntimeException("Cannot add log entry to finished task");
        }

        $this->logEntries[] = $logEntry;
    }


    public function removeLogEntry(LogEntry $logEntry)
    {
        
    }


    /**
     * @return LogEntry[]
     */
    public function getLogEntries()
    {
        return $this->logEntries;
    }

}
