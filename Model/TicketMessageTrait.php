<?php

namespace Hackzilla\Bundle\TicketBundle\Model;

/**
 * Ticket Message Trait.
 */
trait TicketMessageTrait
{
    protected $ticket;

    /**
     * @var int
     */
    protected $user;

    protected $userObject;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var int
     */
    protected $priority;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
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
        if (!empty(TicketMessageInterface::STATUSES[$this->status])) {
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
        if (!empty(TicketMessageInterface::PRIORITIES[$this->priority])) {
            return TicketMessageInterface::PRIORITIES[$this->priority];
        }

        return TicketMessageInterface::PRIORITIES[0];
    }

    /**
     * Set user.
     *
     * @param int|UserInterface $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        if (\is_object($user)) {
            $this->userObject = $user;
            $this->user       = $user->getId();
        } else {
            $this->userObject = null;
            $this->user       = $user;
        }

        return $this;
    }

    /**
     * Get user.
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get user object.
     *
     * @return UserInterface
     */
    public function getUserObject()
    {
        return $this->userObject;
    }

    /**
     * Set message.
     *
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
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
     * Set ticket.
     *
     * @param TicketInterface $ticket
     *
     * @return $this
     */
    public function setTicket(TicketInterface $ticket = null)
    {
        $this->ticket = $ticket;

        if (\is_null($this->getUserObject())) {
            $user = $this->getUser();
        } else {
            $user = $this->getUserObject();
        }

        // if null, then new ticket
        if (\is_null($ticket->getUserCreated())) {
            $ticket->setUserCreated($user);
        }

        $ticket->setLastUser($user);
        $ticket->setLastMessage($this->getCreatedAt());
        $ticket->setPriority($this->getPriority());

        // if ticket not closed, then it'll be set to null
        if (\is_null($this->getStatus())) {
            $this->setStatus($ticket->getStatus());
        } else {
            $ticket->setStatus($this->getStatus());
        }

        return $this;
    }

    /**
     * Get ticket.
     *
     * @return TicketInterface
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}
