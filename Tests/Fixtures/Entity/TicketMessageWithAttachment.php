<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessageWithAttachment as BaseTicketMessageWithAttachment;

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 *
 * @ORM\Entity()
 */
class TicketMessageWithAttachment extends BaseTicketMessageWithAttachment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
}
