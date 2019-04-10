<?php

namespace Hackzilla\Bundle\TicketBundle\Model;

/**
 * Ticket Message.
 */
abstract class TicketMessageWithAttachment implements TicketMessageInterface, MessageAttachmentInterface
{
    use TicketMessageTrait;
    use MessageAttachmentTrait;

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
