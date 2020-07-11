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

namespace Hackzilla\Bundle\TicketBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Hackzilla\Bundle\TicketBundle\Model\TicketInterface;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;

/**
 * @final since hackzilla/ticket-bundle 3.x.
 */
class UserLoad
{
    protected $userRepository;

    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getSubscribedEvents()
    {
        return [
            'postLoad',
        ];
    }

    public function postLoad(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        // Ignore any entity lifecycle events not relating to this bundles entities.
        if (!$entity instanceof TicketInterface && !$entity instanceof TicketMessageInterface) {
            return;
        }

        $userRepository = $args->getEntityManager()->getRepository($this->userRepository);

        if ($entity instanceof TicketInterface) {
            if (null === $entity->getUserCreatedObject()) {
                $entity->setUserCreated($userRepository->find($entity->getUserCreated()));
            }
            if (null === $entity->getLastUserObject()) {
                $entity->setLastUser($userRepository->find($entity->getLastUser()));
            }
        } elseif ($entity instanceof TicketMessageInterface) {
            if (null === $entity->getUserObject()) {
                $entity->setUser($userRepository->find($entity->getUser()));
            }
        }
    }
}
