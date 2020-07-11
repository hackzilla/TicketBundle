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

namespace Hackzilla\Bundle\TicketBundle;

final class TicketEvents
{
    /**
     * The hackzilla.ticket.create event is thrown each time an ticket is created
     * in the system.
     *
     * The hackzilla.ticket.update event is thrown each time an ticket is updated
     * in the system.
     *
     * The hackzilla.ticket.delete event is thrown each time an ticket is deleted
     * in the system.
     *
     * The event listeners receives an
     * Hackzilla\Bundle\TicketBundle\Event\TicketEvent instance.
     *
     * @var string
     */
    const TICKET_CREATE = 'hackzilla.ticket.create';
    const TICKET_UPDATE = 'hackzilla.ticket.update';
    const TICKET_DELETE = 'hackzilla.ticket.delete';
}
