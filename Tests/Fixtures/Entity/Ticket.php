<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hackzilla\Bundle\TicketBundle\Model\Ticket as BaseTicket;

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 *
 * @ORM\Entity()
 */
class Ticket extends BaseTicket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
}
