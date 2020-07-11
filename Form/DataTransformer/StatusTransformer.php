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

namespace Hackzilla\Bundle\TicketBundle\Form\DataTransformer;

use Hackzilla\Bundle\TicketBundle\Entity\TicketMessage;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * @final since hackzilla/ticket-bundle 3.x.
 */
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

        return null;
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

        return null;
    }
}
