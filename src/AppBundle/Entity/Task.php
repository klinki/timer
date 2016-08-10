<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Task
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\TaskRepository")
 */
class Task
{
    /**
     * @var integer
     *
     * @Groups({"short", "full"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Groups({"short", "full"})
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $owner;


    /**
     * @var LogEntry[]|ArrayCollection
     *
     * @Groups({"full"})
     * @ORM\OneToMany(targetEntity="LogEntry", mappedBy="task")
     */
    protected $logEntries;


    /**
     * @var boolean
     *
     * @Groups({"short", "full"})
     * @ORM\Column(type="boolean")
     */
    protected $isFinished;


    /**
     * @var int
     *
     * @Groups({"short", "full"})
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $estimatedTime;


    /**
     * @var int
     *
     * @Groups({"short", "full"})
     * @ORM\Column(type="boolean")
     */
    protected $isDefault;


    /**
     * Constructor.
     *
     * @param string $name
     * @param User $owner
     */
    public function __construct($name, User $owner)
    {
        $this->name = $name;
        $this->owner = $owner;
        $this->logEntries = new ArrayCollection();
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
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return boolean
     */
    public function isFinished()
    {
        return $this->isFinished;
    }

    /**
     *
     *
     * @param mixed $isFinished
     */
    public function setIsFinished($isFinished)
    {
        $this->isFinished = $isFinished;
    }

    /**
     * Adds new log entry
     *
     * @param LogEntry $logEntry
     */
    public function addLogEntry(LogEntry $logEntry)
    {
        if ($this->isFinished) {
            throw new \RuntimeException("Cannot add log entry to finished task");
        }

        $this->logEntries[] = $logEntry;
    }

    /**
     * Removes log entry
     *
     * @param LogEntry $logEntry
     */
    public function removeLogEntry(LogEntry $logEntry)
    {
        $this->logEntries->removeElement($logEntry);
    }

    /**
     * Gets all log entries
     *
     * @return LogEntry[]|ArrayCollection
     */
    public function getLogEntries()
    {
        return $this->logEntries;
    }

    /**
     * Gets \DateInterval
     *
     * @return int
     */
    public function getEstimatedTime()
    {
        return $this->estimatedTime;
    }

    public function getEstimatedTimeAsInterval()
    {
        return new \DateInterval('PT' . (int)$this->estimatedTime . 'S');
    }

    /**
     * Sets  dependency
     *
     * @param \DateInterval $estimatedTime
     */
    public function setEstimatedTime($estimatedTime)
    {
        $this->estimatedTime = $estimatedTime;
    }

    public function setDefault($value)
    {
        $this->isDefault = $value;
    }

    public function isDefault()
    {
        return $this->isDefault;
    }
}
