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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @final since hackzilla/ticket-bundle 3.x.
 */
class HackzillaTicketExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(self::bundleDirectory().'/Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('hackzilla_ticket.model.user.class', $config['user_class']);
        $container->setParameter('hackzilla_ticket.model.ticket.class', $config['ticket_class']);
        $container->setParameter('hackzilla_ticket.model.message.class', $config['message_class']);

        $container->setParameter('hackzilla_ticket.features', $config['features']);
        $container->setParameter('hackzilla_ticket.templates', $config['templates']);

        $bundles = $container->getParameter('kernel.bundles');
        // Remove "file_upload_subscriber" definition if VichUploaderBundle is not registered
        if (!isset($bundles['VichUploaderBundle'])) {
            $container->removeDefinition('hackzilla_ticket.file_upload_subscriber');
        }
    }

    public static function bundleDirectory()
    {
        return realpath(__DIR__.'/..');
    }
}
