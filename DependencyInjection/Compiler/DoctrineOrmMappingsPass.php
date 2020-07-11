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

namespace Hackzilla\Bundle\TicketBundle\DependencyInjection\Compiler;

use Doctrine\Common\Persistence\Mapping\Driver\SymfonyFileLocator;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Hackzilla\Bundle\TicketBundle\DependencyInjection\HackzillaTicketExtension;
use Hackzilla\Bundle\TicketBundle\Entity\Ticket;
use Hackzilla\Bundle\TicketBundle\Entity\TicketMessage;
use Hackzilla\Bundle\TicketBundle\Entity\TicketMessageWithAttachment;
use Hackzilla\Bundle\TicketBundle\Entity\TicketWithAttachment;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @final since hackzilla/ticket-bundle 3.x.
 */
class DoctrineOrmMappingsPass extends \Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass
{
    public function __construct($driver = null, array $namespaces = [], $managerParameters = [], $enabledParameter = false, array $aliasMap = [])
    {
        parent::__construct($driver, $namespaces, $managerParameters, $enabledParameter, $aliasMap);
    }

    public function process(ContainerBuilder $container)
    {
        $bundleDirectory = HackzillaTicketExtension::bundleDirectory();
        $namespaces = [];

        if (
            TicketWithAttachment::class === $container->getParameter('hackzilla_ticket.model.ticket.class') ||
            TicketMessageWithAttachment::class === $container->getParameter('hackzilla_ticket.model.message.class')
        ) {
            $namespaces[realpath($bundleDirectory.'/Resources/config/doctrine/model/attachment')] = 'Hackzilla\Bundle\TicketBundle\Entity';
        } elseif (
            Ticket::class === $container->getParameter('hackzilla_ticket.model.ticket.class') ||
            TicketMessage::class === $container->getParameter('hackzilla_ticket.model.message.class')
        ) {
            $namespaces[realpath($bundleDirectory.'/Resources/config/doctrine/model/plain')] = 'Hackzilla\Bundle\TicketBundle\Entity';
        }

        $arguments = [$namespaces, '.orm.xml'];
        $locator = new Definition(SymfonyFileLocator::class, $arguments);
        $this->driver = new Definition(XmlDriver::class, [$locator]);
        $this->namespaces = $namespaces;

        parent::process($container);
    }
}
