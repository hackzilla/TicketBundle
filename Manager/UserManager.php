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

namespace Hackzilla\Bundle\TicketBundle\Manager;

use Doctrine\Common\Persistence\ObjectRepository;
use Hackzilla\Bundle\TicketBundle\Model\TicketInterface;
use Hackzilla\Bundle\TicketBundle\Model\UserInterface;
use Hackzilla\Bundle\TicketBundle\TicketRole;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @final since hackzilla/ticket-bundle 3.x.
 */
class UserManager implements UserManagerInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var ObjectRepository
     */
    private $userRepository;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        ObjectRepository $userRepository,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->userRepository = $userRepository;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @return int|UserInterface
     */
    public function getCurrentUser()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ('anon.' === $user) {
            $user = 0;
        }

        return $user;
    }

    /**
     * @param int $userId
     */
    public function getUserById($userId): ?UserInterface
    {
        if (!$userId) {
            return null;
        }

        return $this->userRepository->find($userId);
    }

    /**
     * Current user has permission.
     */
    public function hasRole(UserInterface $user, string $role): bool
    {
        return $this->authorizationChecker->isGranted($role);
    }

    /**
     * @param UserInterface|string $user
     */
    public function hasPermission($user, TicketInterface $ticket): void
    {
        if (!\is_object($user) || (!$this->hasRole($user, TicketRole::ADMIN) &&
            $ticket->getUserCreated() != $user->getId())
        ) {
            throw new AccessDeniedHttpException();
        }
    }
}
