<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
     *
     * @ORM\Column(name="`from`", type="datetime")
     */
    protected $from;

    /**
     * @var \DateTime
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
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets from date
     *
     * @return \DateTime
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Sets from date
     *
     * @param \DateTime $from
     */
    public function setFrom(\DateTime $from)
    {
        $this->from = $from;
    }

    /**
     * Gets to date
     *
     * @return \DateTime
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Sets to date dependency
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
     * Sets Task
     *
     * @param Task $task
     */
    public function setTask(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @return \DateInterval
     */
    public function getDuration()
    {
        return $this->to->diff($this->from);
    }

    /**
     * Gets text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Sets text
     *
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }
}
