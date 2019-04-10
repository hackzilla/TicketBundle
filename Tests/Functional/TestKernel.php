<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\Functional;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Hackzilla\Bundle\TicketBundle\HackzillaTicketBundle;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\Ticket;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\TicketMessage;
use Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity\User;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Vich\UploaderBundle\VichUploaderBundle;

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 */
class TestKernel extends Kernel
{
    use MicroKernelTrait;

    private $useVichUploaderBundle = false;

    public function __construct()
    {
        $this->useVichUploaderBundle = \class_exists(VichUploaderBundle::class);

        parent::__construct('test'.(int) $this->useVichUploaderBundle, true);
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = [
            new FrameworkBundle(),
            new SecurityBundle(),
            new DoctrineBundle(),
            new HackzillaTicketBundle(),
            new TestBundle(),
        ];

        if ($this->useVichUploaderBundle) {
            $bundles[] = new VichUploaderBundle();
        }

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        // FrameworkBundle config
        $c->loadFromExtension('framework', [
            'secret'         => 'MySecretKey',
            'default_locale' => 'en',
            'translator'     => [
                'fallbacks' => [
                    'en',
                ],
            ],
            'validation' => [
                'enabled' => true,
            ],
        ]);

        // SecurityBundle config
        $c->loadFromExtension('security', [
            'providers' => [
                'in_memory' => [
                    'memory' => null,
                ],
            ],
            'firewalls' => [
                'main' => [
                    'anonymous' => null,
                ],
            ],
        ]);

        // DoctrineBundle config
        $c->loadFromExtension('doctrine', [
            'dbal' => [
                'connections' => [
                    'default' => [
                        'driver' => 'pdo_sqlite',
                        'memory' => true,
                    ],
                ],
            ],
            'orm' => [
                'default_entity_manager' => 'default',
                'mappings'               => [
                    'TestBundle' => [
                        'type'      => 'annotation',
                        'dir'       => __DIR__.'/../Fixtures/Entity',
                        'is_bundle' => false,
                        'prefix'    => 'Hackzilla\Bundle\TicketBundle\Tests\Fixtures\Entity',
                        'alias'     => 'TestBundle',
                    ],
                ],
            ],
        ]);

        // HackzillaBundle config
        $c->loadFromExtension('hackzilla_ticket', [
            'user_class'    => User::class,
            'ticket_class'  => Ticket::class,
            'message_class' => TicketMessage::class,
        ]);

        if ($this->useVichUploaderBundle) {
            // FrameworkBundle config
            // "framework.form" is required since "vich_uploader.namer_directory_property"
            // service uses "form.property_accessor" service.
            $c->loadFromExtension('framework', [
                'form' => null,
            ]);

            // VichUploaderBundle config
            $c->loadFromExtension('vich_uploader', [
                'db_driver' => 'orm',
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return parent::getCacheDir().'/'.(int) $this->useVichUploaderBundle;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return parent::getLogDir().'/'.(int) $this->useVichUploaderBundle;
    }

    public function serialize()
    {
        return serialize($this->useVichUploaderBundle);
    }

    public function unserialize($str)
    {
        $this->__construct(unserialize($str));
    }
}
