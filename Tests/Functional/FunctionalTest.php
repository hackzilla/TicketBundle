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

namespace Hackzilla\Bundle\TicketBundle\Tests\Functional;

use Hackzilla\Bundle\TicketBundle\Entity\Ticket;
use Hackzilla\Bundle\TicketBundle\Entity\TicketMessage;
use Hackzilla\Bundle\TicketBundle\Manager\TicketManagerInterface;
use Hackzilla\Bundle\TicketBundle\Tests\Functional\Entity\User;
use Twig\Template;
use Vich\UploaderBundle\Event\Events;

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 */
final class FunctionalTest extends WebTestCase
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
                'index' => '@HackzillaTicket/Ticket/index.html.twig',
                'new' => '@HackzillaTicket/Ticket/new.html.twig',
                'prototype' => '@HackzillaTicket/Ticket/prototype.html.twig',
                'show' => '@HackzillaTicket/Ticket/show.html.twig',
                'show_attachment' => '@HackzillaTicket/Ticket/show_attachment.html.twig',
                'macros' => '@HackzillaTicket/Macros/macros.html.twig',
            ]],
        ];
    }

    public function testConfiguredTicketManager(): void
    {
        $this->assertTrue(static::$kernel->getContainer()->has('hackzilla_ticket.ticket_manager'));
        $this->assertInstanceOf(TicketManagerInterface::class, static::$kernel->getContainer()->get('hackzilla_ticket.ticket_manager'));
    }

    /**
     * @group vichuploaderbundle
     */
    public function testConfiguredFileUploadSubscriber(): void
    {
        $eventDispatcher = static::$kernel->getContainer()->get('event_dispatcher');
        $listeners = $eventDispatcher->getListeners();

        $this->assertArrayHasKey(Events::POST_UPLOAD, $listeners);
    }

    public function testTemplateLoad(): void
    {
        $twig = static::$kernel->getContainer()->get('twig');

        $this->assertInstanceOf(Template::class, $twig->loadTemplate('@HackzillaTicket/Ticket/index.html.twig'));
    }
}
