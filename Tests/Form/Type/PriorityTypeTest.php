<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Form\Type;

use Hackzilla\Bundle\TicketBundle\Form\Type\PriorityType;
use Symfony\Component\Form\Test\TypeTestCase;

class PriorityTypeTest extends TypeTestCase
{
    private $object;

    protected function setUp()
    {
        $this->object = new PriorityType();
    }

    protected function tearDown()
    {
        unset($this->object);
    }

    public function testObjectCreated()
    {
        $this->assertInstanceOf(PriorityType::class, $this->object);
    }
}
