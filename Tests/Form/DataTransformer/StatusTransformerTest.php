<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Form\DataTransformer;

use Hackzilla\Bundle\TicketBundle\Form\DataTransformer\StatusTransformer;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessage;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StatusTransformerTest extends WebTestCase
{
    private $object;

    protected function setUp()
    {
        $this->object = new StatusTransformer();
    }

    protected function tearDown()
    {
        unset($this->object);
    }

    public function testObjectCreated()
    {
        $this->assertInstanceOf(StatusTransformer::class, $this->object);
    }

    public function testTransform()
    {
        $this->assertSame($this->object->transform(TicketMessage::STATUS_CLOSED), 1);

        $this->assertNull($this->object->transform('TEST'));
    }

    public function testReverseTransform()
    {
        $this->assertSame($this->object->reverseTransform(1), TicketMessage::STATUS_CLOSED);

        $this->assertNull($this->object->reverseTransform('TEST'));
    }
}
