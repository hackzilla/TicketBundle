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

namespace Hackzilla\Bundle\TicketBundle\Tests\EventListener;

use Hackzilla\Bundle\TicketBundle\EventListener\UserLoad;
use Hackzilla\Bundle\TicketBundle\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UserLoadTest extends WebTestCase
{
    private $object;

    protected function setUp(): void
    {
        $userManager = $this->getUserManagerMock();

        $this->object = new UserLoad($userManager);
    }

    protected function tearDown(): void
    {
        $this->object = null;
    }

    public function getUserManagerMock()
    {
        return $this->createMock(UserManager::class);
    }

    public function testObjectCreated(): void
    {
        $this->assertInstanceOf(UserLoad::class, $this->object);
    }
}
