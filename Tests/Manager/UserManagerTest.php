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

namespace Hackzilla\Bundle\TicketBundle\Tests\User;

use Doctrine\ORM\EntityRepository;
use Hackzilla\Bundle\TicketBundle\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Authentication\Provider\AnonymousAuthenticationProvider;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

final class UserManagerTest extends WebTestCase
{
    private $object;

    private $tokenStorage;

    private $authorizationChecker;

    protected function setUp(): void
    {
        $this->tokenStorage = new TokenStorage();
        $authenticationProviderManager = new AuthenticationProviderManager([new AnonymousAuthenticationProvider('secret')]);
        $accessDecisionManager = new AccessDecisionManager();
        $this->authorizationChecker = new AuthorizationChecker($this->tokenStorage, $authenticationProviderManager, $accessDecisionManager);

        $this->object = new UserManager(
            $this->tokenStorage,
            $this->getMockUserRepository(),
            $this->authorizationChecker
        );
    }

    protected function tearDown(): void
    {
        $this->object = null;
    }

    public function testObjectCreated(): void
    {
        $this->assertInstanceOf(UserManager::class, $this->object);
    }

    private function getMockUserRepository()
    {
        return $this->createMock(EntityRepository::class);
    }
}
