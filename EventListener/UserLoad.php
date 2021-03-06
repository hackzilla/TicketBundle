<?php

/*
 * This file is part of HackzillaTicketBundle package.
 *
 * (c) Daniel Platt <github@ofdan.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hackzilla\Bundle\TicketBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Hackzilla\Bundle\TicketBundle\Manager\UserManagerInterface;
use Hackzilla\Bundle\TicketBundle\Model\TicketInterface;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;

/**
 * @final since hackzilla/ticket-bundle 3.x.
 */
class UserLoad
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function getSubscribedEvents()
    {
        return [
            'postLoad',
        ];
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // Ignore any entity lifecycle events not related to this bundle's entities.
        if (!$entity instanceof TicketInterface && !$entity instanceof TicketMessageInterface) {
            return;
        }

        if ($entity instanceof TicketInterface) {
            if (null === $entity->getUserCreatedObject()) {
                $entity->setUserCreated($this->userManager->getUserById($entity->getUserCreated()));
            }
            if (null === $entity->getLastUserObject()) {
                $entity->setLastUser($this->userManager->getUserById($entity->getLastUser()));
            }
        } elseif ($entity instanceof TicketMessageInterface) {
            if (null === $entity->getUserObject()) {
                $entity->setUser($this->userManager->getUserById($entity->getUser()));
            }
        }
    }
}
