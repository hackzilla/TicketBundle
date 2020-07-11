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

namespace Hackzilla\Bundle\TicketBundle\Model;

use Doctrine\Common\Collections\Collection;

interface TicketInterface
{
    /**
     * Get ticket id.
     *
     * @return mixed
     */
    public function getId();

    /**
     * Set status.
     *
     * @return $this
     */
    public function setStatus(int $status);

    /**
     * Set ticket status by string.
     *
     * @return $this
     */
    public function setStatusString(string $status);

    /**
     * Get ticket status.
     */
    public function getStatus(): ?int;

    /**
     * Get ticket status string.
     */
    public function getStatusString(): ?string;

    /**
     * Set ticket priority.
     *
     * @return $this
     */
    public function setPriority(int $priority);

    /**
     * Set ticket priority string.
     *
     * @return $this
     */
    public function setPriorityString(string $priority);

    /**
     * Get priority.
     */
    public function getPriority(): ?int;

    /**
     * Get priority string.
     */
    public function getPriorityString(): ?string;

    /**
     * Set userCreated.
     *
     * @param int|UserInterface $userCreated
     *
     * @return $this
     */
    public function setUserCreated($userCreated);

    /**
     * Get userCreated.
     *
     * @return int
     */
    public function getUserCreated();

    /**
     * Get userCreated object.
     */
    public function getUserCreatedObject(): ?UserInterface;

    /**
     * Set lastUser.
     *
     * @param int|UserInterface $lastUser
     *
     * @return $this
     */
    public function setLastUser($lastUser);

    /**
     * Get lastUser id.
     *
     * @return mixed
     */
    public function getLastUser();

    /**
     * Get lastUser object.
     */
    public function getLastUserObject(): ?UserInterface;

    /**
     * Set lastMessage.
     *
     * @return $this
     */
    public function setLastMessage(\DateTimeInterface $lastMessage);

    /**
     * Get lastMessage.
     */
    public function getLastMessage(): ?\DateTimeInterface;

    /**
     * Set createdAt.
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt);

    /**
     * Get createdAt.
     */
    public function getCreatedAt(): ?\DateTimeInterface;

    /**
     * Set subject.
     *
     * @return $this
     */
    public function setSubject(string $subject);

    /**
     * Get ticket subject.
     */
    public function getSubject(): ?string;

    /**
     * Add message.
     *
     * @return $this
     */
    public function addMessage(TicketMessageInterface $message);

    /**
     * Remove message.
     */
    public function removeMessage(TicketMessageInterface $message);

    /**
     * Get messages.
     */
    public function getMessages(): Collection;
}
