<?php

namespace Hackzilla\Bundle\TicketBundle\Tests\EventListener;

use Hackzilla\Bundle\TicketBundle\EventListener\UserLoad;
use Hackzilla\Bundle\TicketBundle\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserLoadTest extends WebTestCase
{
    private $object;

    protected function setUp()
    {
        $userManager = $this->getUserManagerMock();

        $this->object = new UserLoad($userManager);
    }

    public function getUserManagerMock()
    {
        return $this
            ->getMockBuilder(UserManager::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        unset($this->object);
    }

    public function testObjectCreated()
    {
        $this->assertInstanceOf(UserLoad::class, $this->object);
    }
}
