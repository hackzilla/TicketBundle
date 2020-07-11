<?php

declare(strict_types=1);

/*
 * This file is part of HackzillaTicketBundle package.
 *
 * (c) Daniel Platt <github@ofdan.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hackzilla\Bundle\TicketBundle\Tests\Form\Type;

use Hackzilla\Bundle\TicketBundle\Component\TicketFeatures;
use Hackzilla\Bundle\TicketBundle\Entity\TicketMessage;
use Hackzilla\Bundle\TicketBundle\Form\Type\TicketMessageType;
use Hackzilla\Bundle\TicketBundle\Manager\UserManagerInterface;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

final class TicketMessageTypeTest extends TypeTestCase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = $this->createMock(UserManagerInterface::class);

        parent::setUp();
    }

    public function testSubmitValidData(): void
    {
        $formData = [
            'priority' => TicketMessage::PRIORITY_HIGH,
            'message' => null,
        ];

        $form = $this->factory->create(
            TicketMessageType::class,
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

        $this->assertInstanceOf(TicketMessageInterface::class, $formEntity);
        $this->assertNull($formEntity->getId());
        $this->assertNull($formEntity->getTicket());
        $this->assertNull($formEntity->getUser());
        $this->assertNull($formEntity->getUserObject());
        $this->assertNull($formEntity->getMessage());
        $this->assertNull($formEntity->getStatus());
        $this->assertSame(TicketMessage::PRIORITY_HIGH, $formEntity->getPriority());
        $this->assertInstanceOf(\DateTime::class, $formEntity->getCreatedAt());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    protected function getExtensions()
    {
        $ticketMessageType = new TicketMessageType($this->user, new TicketFeatures([], ''), TicketMessage::class);

        return [
            new PreloadedExtension(
                [
                    $ticketMessageType->getBlockPrefix() => $ticketMessageType,
                ],
                []
            ),
        ];
    }
}
