<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessage as BaseTicketMessage;

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 *
 * @ORM\Entity()
 */
class TicketMessage extends BaseTicketMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
}
