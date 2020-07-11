<?php

declare(strict_types=1);

/*
 * This file is part of HackzillaTicketBundle package.
 *
 * (c) Daniel Platt <github@ofdan.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hackzilla\Bundle\TicketBundle\Entity\Traits;

use Hackzilla\Bundle\TicketBundle\Model\TicketInterface;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;
use Hackzilla\Bundle\TicketBundle\Model\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
     *
     * @Assert\NotBlank()
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
     * @return $this
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set status string.
     *
     * @return $this
     */
    public function setStatusString(string $status)
    {
        $status = array_search(strtolower($status), TicketMessageInterface::STATUSES, true);

        if ($status > 0) {
            $this->setStatus($status);
        }

        return $this;
    }

    /**
     * Get status.
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * Get status string.
     */
    public function getStatusString(): ?string
    {
        if (!empty(TicketMessageInterface::STATUSES[$this->status])) {
            return TicketMessageInterface::STATUSES[$this->status];
        }

        return TicketMessageInterface::STATUSES[0];
    }

    /**
     * Set priority.
     *
     * @return $this
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Set priority string.
     *
     * @return $this
     */
    public function setPriorityString(string $priority)
    {
        $priority = array_search(strtolower($priority), TicketMessageInterface::PRIORITIES, true);

        if ($priority > 0) {
            $this->setPriority($priority);
        }

        return $this;
    }

    /**
     * Get priority.
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * Get priority string.
     */
    public function getPriorityString(): ?string
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
            $this->user = $user->getId();
        } else {
            $this->userObject = null;
            $this->user = $user;
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
     */
    public function getUserObject(): ?UserInterface
    {
        return $this->userObject;
    }

    /**
     * Set message.
     *
     * @return $this
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Set createdAt.
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
     * @return $this
     */
    public function setTicket(?TicketInterface $ticket = null)
    {
        $this->ticket = $ticket;

        if (null === $this->getUserObject()) {
            $user = $this->getUser();
        } else {
            $user = $this->getUserObject();
        }

        // if null, then new ticket
        if (null === $ticket->getUserCreated()) {
            $ticket->setUserCreated($user);
        }

        $ticket->setLastUser($user);
        $ticket->setLastMessage($this->getCreatedAt());
        $ticket->setPriority($this->getPriority());

        // if ticket not closed, then it'll be set to null
        if (null === $this->getStatus()) {
            $this->setStatus($ticket->getStatus());
        } else {
            $ticket->setStatus($this->getStatus());
        }

        return $this;
    }

    /**
     * Get ticket.
     */
    public function getTicket(): ?TicketInterface
    {
        return $this->ticket;
    }
}
