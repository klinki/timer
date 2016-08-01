<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * LogEntry
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\LogEntryRepository")
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

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="`text`", type="string", nullable=true)
     */
    protected $text;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="`from`", type="datetime")
     */
    protected $from;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="`to`", type="datetime", nullable=true)
     */
    protected $to;

    /**
     * @var Task
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Task", inversedBy="logEntries")
     */
    protected $task;

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
     * Gets mixed
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets mixed dependency
     *
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets DateTime
     *
     * @return DateTime
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Sets DateTime dependency
     *
     * @param \DateTime $from
     */
    public function setFrom(\DateTime $from)
    {
        $this->from = $from;
    }

    /**
     * Gets DateTime
     *
     * @return DateTime
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Sets DateTime dependency
     *
     * @param \DateTime $to
     */
    public function setTo(\DateTime $to)
    {
        $this->to = $to;
    }

    /**
     * Gets Task
     *
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Sets Task dependency
     *
     * @param Task $task
     */
    public function setTask(Task $task)
    {
        $this->task = $task;
    }
}
