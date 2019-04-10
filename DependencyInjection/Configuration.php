<?php

namespace Hackzilla\Bundle\TicketBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('hackzilla_ticket');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('hackzilla_ticket');
        }

        $rootNode
            ->children()
                ->scalarNode('user_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('ticket_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('message_class')->isRequired()->cannotBeEmpty()->end()
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
                        ->scalarNode('index')->defaultValue('HackzillaTicketBundle:Ticket:index.html.twig')->end()
                        ->scalarNode('new')->defaultValue('HackzillaTicketBundle:Ticket:new.html.twig')->end()
                        ->scalarNode('prototype')->defaultValue('HackzillaTicketBundle:Ticket:prototype.html.twig')->end()
                        ->scalarNode('show')->defaultValue('HackzillaTicketBundle:Ticket:show.html.twig')->end()
                        ->scalarNode('show_attachment')->defaultValue('HackzillaTicketBundle:Ticket:show_attachment.html.twig')->end()
                        ->scalarNode('macros')->defaultValue('HackzillaTicketBundle:Macros:macros.html.twig')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
