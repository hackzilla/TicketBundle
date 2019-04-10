<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Form\Type;

use Hackzilla\Bundle\TicketBundle\Form\Type\StatusType;
use Symfony\Component\Form\Test\TypeTestCase;

class StatusTypeTest extends TypeTestCase
{
    private $object;

    protected function setUp()
    {
        $this->object = new StatusType();
    }

    protected function tearDown()
    {
        unset($this->object);
    }

    public function testObjectCreated()
    {
        $this->assertInstanceOf(StatusType::class, $this->object);
    }
}
