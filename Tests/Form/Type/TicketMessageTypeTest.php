<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Form\Type;

use Hackzilla\Bundle\TicketBundle\Component\TicketFeatures;
use Hackzilla\Bundle\TicketBundle\Form\Type\TicketMessageType;
use Hackzilla\Bundle\TicketBundle\Manager\UserManagerInterface;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\TicketMessage;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class TicketMessageTypeTest extends TypeTestCase
{
    private $user;

    protected function setUp()
    {
        $this->user = $this->getMockBuilder(UserManagerInterface::class)->getMock();

        parent::setUp();
    }

    protected function getExtensions()
    {
        $ticketMessageType = new TicketMessageType($this->user, new TicketFeatures([], ''), TicketMessage::class);

        return [
            new PreloadedExtension(
                [
                    $ticketMessageType->getBlockPrefix() => $ticketMessageType,
                ], []
            ),
        ];
    }

    public function testSubmitValidData()
    {
        $formData = [
            'priority' => TicketMessage::PRIORITY_HIGH,
            'message'  => null,
        ];

        $data = new TicketMessage();
        $data->setPriority(TicketMessage::PRIORITY_HIGH);

        $form = $this->factory->create(TicketMessageType::class,
            null,
            [
                'new_ticket' => true,
            ],
            TicketMessage::class
        );

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
