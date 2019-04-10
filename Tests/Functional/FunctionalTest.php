<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Functional;

use Hackzilla\Bundle\TicketBundle\Manager\TicketManagerInterface;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\Ticket;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\TicketMessage;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\User;
use Vich\UploaderBundle\Event\Events;

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 */
class FunctionalTest extends WebTestCase
{
    /**
     * @dataProvider getParameters
     */
    public function testConfiguredParameter($parameter, $value)
    {
        $this->assertTrue(static::$kernel->getContainer()->hasParameter($parameter));
        $this->assertSame($value, static::$kernel->getContainer()->getParameter($parameter));
    }

    public function getParameters()
    {
        return [
            ['hackzilla_ticket.model.user.class', User::class],
            ['hackzilla_ticket.model.ticket.class', Ticket::class],
            ['hackzilla_ticket.model.message.class', TicketMessage::class],
            ['hackzilla_ticket.features', ['attachment' => true]],
            ['hackzilla_ticket.templates', [
                'index'           => 'HackzillaTicketBundle:Ticket:index.html.twig',
                'new'             => 'HackzillaTicketBundle:Ticket:new.html.twig',
                'prototype'       => 'HackzillaTicketBundle:Ticket:prototype.html.twig',
                'show'            => 'HackzillaTicketBundle:Ticket:show.html.twig',
                'show_attachment' => 'HackzillaTicketBundle:Ticket:show_attachment.html.twig',
                'macros'          => 'HackzillaTicketBundle:Macros:macros.html.twig',
            ]],
        ];
    }

    public function testConfiguredTicketManager()
    {
        $this->assertTrue(static::$kernel->getContainer()->has('hackzilla_ticket.ticket_manager'));
        $this->assertInstanceOf(TicketManagerInterface::class, static::$kernel->getContainer()->get('hackzilla_ticket.ticket_manager'));
    }

    public function testValidation()
    {
        $validator = static::$kernel->getContainer()->get('validator');
        $violations = $validator->validate(new Ticket());
        $this->assertNotEmpty($violations);
    }

    /**
     * @group vichuploaderbundle
     */
    public function testConfiguredFileUploadSubscriber()
    {
        $eventDispatcher = static::$kernel->getContainer()->get('event_dispatcher');
        $listeners       = $eventDispatcher->getListeners();

        $this->assertArrayHasKey(Events::POST_UPLOAD, $listeners);
    }
}
