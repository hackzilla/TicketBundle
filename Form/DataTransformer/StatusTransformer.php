<?php

namespace Hackzilla\Bundle\TicketBundle\Form\DataTransformer;

use Hackzilla\Bundle\TicketBundle\Model\TicketMessage;
use Symfony\Component\Form\DataTransformerInterface;

class StatusTransformer implements DataTransformerInterface
{
    /**
     * Transforms checkbox value into Ticket Message Status Closed.
     *
     * @param int $number
     *
     * @return int|null
     */
    public function transform($number)
    {
        if (TicketMessage::STATUS_CLOSED == $number) {
            return 1;
        }

        return;
    }

    /**
     * Transforms Ticket Message Status Closed into checkbox value checked.
     *
     * @param int $number
     *
     * @return int|null
     */
    public function reverseTransform($number)
    {
        if (1 == $number) {
            return TicketMessage::STATUS_CLOSED;
        }

        return;
    }
}
