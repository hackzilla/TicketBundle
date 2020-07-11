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

use Doctrine\Common\Collections\ArrayCollection;
use Hackzilla\Bundle\TicketBundle\Component\TicketFeatures;
use Hackzilla\Bundle\TicketBundle\Entity\Ticket;
use Hackzilla\Bundle\TicketBundle\Entity\TicketMessage;
use Hackzilla\Bundle\TicketBundle\Form\Type\TicketMessageType;
use Hackzilla\Bundle\TicketBundle\Form\Type\TicketType;
use Hackzilla\Bundle\TicketBundle\Manager\UserManagerInterface;
use Hackzilla\Bundle\TicketBundle\Model\TicketInterface;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

final class TicketTypeTest extends TypeTestCase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = $this->createMock(UserManagerInterface::class);

        parent::setUp();
    }

    public function testSubmitValidData(): void
    {
        $formData = [];

        $form = $this->factory->create(TicketType::class);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $formEntity = $form->getData();

        $this->assertInstanceOf(TicketInterface::class, $formEntity);
        $this->assertNull($formEntity->getId());
        $this->assertNull($formEntity->getUserCreated());
        $this->assertNull($formEntity->getUserCreatedObject());
        $this->assertNull($formEntity->getLastUser());
        $this->assertNull($formEntity->getLastUserObject());
        $this->assertNull($formEntity->getPriority());
        $this->assertNull($formEntity->getStatus());
        $this->assertNull($formEntity->getLastMessage());
        $this->assertInstanceOf(ArrayCollection::class, $formEntity->getMessages());
        $this->assertEmpty($formEntity->getMessages());
        $this->assertInstanceOf(\DateTime::class, $formEntity->getCreatedAt());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    protected function getExtensions()
    {
        $ticketType = new TicketType(Ticket::class);
        $ticketMessageType = new TicketMessageType($this->user, new TicketFeatures([], ''), TicketMessage::class);

        return [
            new PreloadedExtension(
                [
                    $ticketType->getBlockPrefix() => $ticketType,
                    $ticketMessageType->getBlockPrefix() => $ticketMessageType,
                ],
                []
            ),
        ];
    }
}
