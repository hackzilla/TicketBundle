<?php

namespace Hackzilla\Bundle\TicketBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Ticket Trait.
 */
trait TicketTrait
{
    /**
     * @var int
     */
    protected $userCreated;

    protected $userCreatedObject;

    /**
     * @var int
     */
    protected $lastUser;

    protected $lastUserObject;

    /**
     * @var \DateTime
     */
    protected $lastMessage;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var int
     */
    protected $priority;

    /**
     * @var ArrayCollection
     */
    protected $messages;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->messages = new ArrayCollection();
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set status string.
     *
     * @param string $status
     *
     * @return $this
     */
    public function setStatusString($status)
    {
        $status = \array_search(\strtolower($status), TicketMessageInterface::STATUSES);

        if ($status > 0) {
            $this->setStatus($status);
        }

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get status string.
     *
     * @return string
     */
    public function getStatusString()
    {
        if (array_key_exists($this->status, TicketMessageInterface::STATUSES)) {
            return TicketMessageInterface::STATUSES[$this->status];
        }

        return TicketMessageInterface::STATUSES[0];
    }

    /**
     * Set priority.
     *
     * @param int $priority
     *
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Set priority string.
     *
     * @param string $priority
     *
     * @return $this
     */
    public function setPriorityString($priority)
    {
        $priority = \array_search(\strtolower($priority), TicketMessageInterface::PRIORITIES);

        if ($priority > 0) {
            $this->setPriority($priority);
        }

        return $this;
    }

    /**
     * Get priority.
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Get priority string.
     *
     * @return string
     */
    public function getPriorityString()
    {
        if (array_key_exists($this->priority, TicketMessageInterface::PRIORITIES)) {
            return TicketMessageInterface::PRIORITIES[$this->priority];
        }

        return TicketMessageInterface::PRIORITIES[0];
    }

    /**
     * Set userCreated.
     *
     * @param int|object $userCreated
     *
     * @return $this
     */
    public function setUserCreated($userCreated)
    {
        if (\is_object($userCreated)) {
            $this->userCreatedObject = $userCreated;
            $this->userCreated       = $userCreated->getId();
        } else {
            $this->userCreatedObject = null;
            $this->userCreated       = $userCreated;
        }

        return $this;
    }

    /**
     * Get userCreated.
     *
     * @return int
     */
    public function getUserCreated()
    {
        return $this->userCreated;
    }

    /**
     * Get userCreated object.
     *
     * @return object
     */
    public function getUserCreatedObject()
    {
        return $this->userCreatedObject;
    }

    /**
     * Set lastUser.
     *
     * @param int|object $lastUser
     *
     * @return $this
     */
    public function setLastUser($lastUser)
    {
        if (\is_object($lastUser)) {
            $this->lastUserObject = $lastUser;
            $this->lastUser       = $lastUser->getId();
        } else {
            $this->lastUserObject = null;
            $this->lastUser       = $lastUser;
        }

        return $this;
    }

    /**
     * Get lastUser.
     *
     * @return int
     */
    public function getLastUser()
    {
        return $this->lastUser;
    }

    /**
     * Get lastUser object.
     *
     * @return UserInterface
     */
    public function getLastUserObject()
    {
        return $this->lastUserObject;
    }

    /**
     * Set lastMessage.
     *
     * @param \DateTime $lastMessage
     *
     * @return $this
     */
    public function setLastMessage($lastMessage)
    {
        $this->lastMessage = $lastMessage;

        return $this;
    }

    /**
     * Get lastMessage.
     *
     * @return \DateTime
     */
    public function getLastMessage()
    {
        return $this->lastMessage;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set subject.
     *
     * @param string $subject
     *
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Add message.
     *
     * @param TicketMessageInterface $message
     *
     * @return $this
     */
    public function addMessage(TicketMessageInterface $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message.
     *
     * @param TicketMessageInterface $message
     *
     * @return $this
     */
    public function removeMessage(TicketMessageInterface $message)
    {
        $this->messages->removeElement($message);

        return $this;
    }

    /**
     * Get messages.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
