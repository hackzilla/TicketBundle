<?php

namespace Hackzilla\Bundle\TicketBundle\Model;

/**
 * Ticket.
 */
abstract class TicketWithAttachment implements TicketInterface
{
    use TicketTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
