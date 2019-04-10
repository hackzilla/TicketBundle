<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Entity;

use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\TicketMessageWithAttachment;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketMessageWithAttachmentTest extends WebTestCase
{
    private $object;

    protected function setUp()
    {
        $this->object = new TicketMessageWithAttachment();
    }

    protected function tearDown()
    {
        unset($this->object);
    }

    public function testObjectCreated()
    {
        $this->assertInstanceOf(TicketMessageInterface::class, $this->object);
    }
}
