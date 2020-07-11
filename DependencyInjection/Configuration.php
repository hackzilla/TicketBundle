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

namespace Hackzilla\Bundle\TicketBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @final since hackzilla/ticket-bundle 3.x.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('hackzilla_ticket');

        $treeBuilder
            ->getRootNode()
            ->children()
                ->scalarNode('user_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('ticket_class')->cannotBeEmpty()->defaultValue('Hackzilla\Bundle\TicketBundle\Entity\Ticket')->end()
                ->scalarNode('message_class')->cannotBeEmpty()->defaultValue('Hackzilla\Bundle\TicketBundle\Entity\TicketMessage')->end()
                ->arrayNode('features')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('attachment')->defaultTrue()->end()
                    ->end()
                ->end()
                ->arrayNode('templates')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('index')->defaultValue('@HackzillaTicket/Ticket/index.html.twig')->end()
                        ->scalarNode('new')->defaultValue('@HackzillaTicket/Ticket/new.html.twig')->end()
                        ->scalarNode('prototype')->defaultValue('@HackzillaTicket/Ticket/prototype.html.twig')->end()
                        ->scalarNode('show')->defaultValue('@HackzillaTicket/Ticket/show.html.twig')->end()
                        ->scalarNode('show_attachment')->defaultValue('@HackzillaTicket/Ticket/show_attachment.html.twig')->end()
                        ->scalarNode('macros')->defaultValue('@HackzillaTicket/Macros/macros.html.twig')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
