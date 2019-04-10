<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Entity;

use Hackzilla\Bundle\TicketBundle\Model\TicketInterface;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketTest extends WebTestCase
{
    private $object;

    protected function setUp()
    {
        parent::setUp();

        $this->object = new Ticket();
    }

    protected function tearDown()
    {
        unset($this->object);
    }

    public function testObjectCreated()
    {
        $this->assertInstanceOf(TicketInterface::class, $this->object);
    }

    public function testStatus()
    {
        $this->object->setStatus(TicketMessageInterface::STATUS_INVALID);
        $this->assertSame(TicketMessageInterface::STATUS_INVALID, $this->object->getStatus());
    }
}
