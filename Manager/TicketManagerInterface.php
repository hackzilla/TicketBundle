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

namespace Hackzilla\Bundle\TicketBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;
use Hackzilla\Bundle\TicketBundle\Model\TicketInterface;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;
use Symfony\Component\Translation\TranslatorInterface;

interface TicketManagerInterface
{
    public function setEntityManager(ObjectManager $om);

    public function setTranslator(TranslatorInterface $translator);

    public function createTicket();

    public function createMessage(?TicketInterface $ticket = null);

    public function updateTicket(TicketInterface $ticket, ?TicketMessageInterface $message = null): void;

    public function deleteTicket(TicketInterface $ticket): void;

    public function getTicketById($ticketId);

    public function getMessageById($ticketMessageId);

    public function findTickets();

    public function findTicketsBy(array $criteria);

    public function getTicketListQuery(UserManagerInterface $userManager, int $ticketStatus, ?int $ticketPriority = null): QueryBuilder;

    /**
     * @return mixed
     */
    public function getResolvedTicketOlderThan(int $days);

    /**
     * Lookup status code.
     *
     * @return int
     */
    public function getTicketStatus(string $statusStr);

    /**
     * Lookup priority code.
     *
     * @return int
     */
    public function getTicketPriority(string $priorityStr);
}
