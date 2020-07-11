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

namespace Hackzilla\Bundle\TicketBundle\Event;

use Hackzilla\Bundle\TicketBundle\Model\TicketInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @final since hackzilla/ticket-bundle 3.x.
 */
class TicketEvent extends Event
{
    protected $ticket;

    public function __construct(TicketInterface $ticket)
    {
        $this->ticket = $ticket;
    }

    public function getTicket(): TicketInterface
    {
        return $this->ticket;
    }
}
