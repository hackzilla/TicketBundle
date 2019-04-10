<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Entity;

use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\TicketMessage;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketMessageTest extends WebTestCase
{
    private $object;

    protected function setUp()
    {
        $this->object = new TicketMessage();
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
