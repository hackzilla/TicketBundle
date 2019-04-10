<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Form\Type;

use Hackzilla\Bundle\TicketBundle\Component\TicketFeatures;
use Hackzilla\Bundle\TicketBundle\Form\Type\TicketMessageType;
use Hackzilla\Bundle\TicketBundle\Form\Type\TicketType;
use Hackzilla\Bundle\TicketBundle\Manager\UserManagerInterface;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\Ticket;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\TicketMessage;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class TicketTypeTest extends TypeTestCase
{
    private $user;

    protected function setUp()
    {
        $this->user = $this->createMock(UserManagerInterface::class);

        parent::setUp();
    }

    protected function getExtensions()
    {
        $ticketType        = new TicketType(Ticket::class);
        $ticketMessageType = new TicketMessageType($this->user, new TicketFeatures([], ''), TicketMessage::class);

        return [
            new PreloadedExtension(
                [
                    $ticketType->getBlockPrefix()        => $ticketType,
                    $ticketMessageType->getBlockPrefix() => $ticketMessageType,
                ], []
            ),
        ];
    }

    public function testSubmitValidData()
    {
        $formData = [];

        $data = new Ticket();

        $form = $this->factory->create(TicketType::class);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $formEntity = $form->getData();
        $formEntity->setCreatedAt($data->getCreatedAt());
        $this->assertEquals($data, $formEntity);

        $view     = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
