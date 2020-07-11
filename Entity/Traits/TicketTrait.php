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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;
use Hackzilla\Bundle\TicketBundle\Model\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     *
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
     * @Assert\Count(min = "1")
     * @Assert\Valid()
     *
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
        if (\array_key_exists($this->status, TicketMessageInterface::STATUSES)) {
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
        if (\array_key_exists($this->priority, TicketMessageInterface::PRIORITIES)) {
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
            $this->userCreated = $userCreated->getId();
        } else {
            $this->userCreatedObject = null;
            $this->userCreated = $userCreated;
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
     */
    public function getUserCreatedObject(): ?UserInterface
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
            $this->lastUser = $lastUser->getId();
        } else {
            $this->lastUserObject = null;
            $this->lastUser = $lastUser;
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
     */
    public function getLastUserObject(): ?UserInterface
    {
        return $this->lastUserObject;
    }

    /**
     * Set lastMessage.
     *
     * @return $this
     */
    public function setLastMessage(\DateTimeInterface $lastMessage)
    {
        $this->lastMessage = $lastMessage;

        return $this;
    }

    /**
     * Get lastMessage.
     */
    public function getLastMessage(): ?\DateTimeInterface
    {
        return $this->lastMessage;
    }

    /**
     * Set createdAt.
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set subject.
     *
     * @return $this
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject.
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * Add message.
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
     * @return $this
     */
    public function removeMessage(TicketMessageInterface $message)
    {
        $this->messages->removeElement($message);

        return $this;
    }

    /**
     * Get messages.
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }
}
