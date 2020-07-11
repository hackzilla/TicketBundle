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

namespace Hackzilla\Bundle\TicketBundle\Tests\Entity;

use Hackzilla\Bundle\TicketBundle\Entity\Ticket;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TicketTest extends WebTestCase
{
    private $object;

    protected function setUp(): void
    {
        $this->object = new Ticket();
    }

    protected function tearDown(): void
    {
        $this->object = null;
    }

    public function testObjectCreated(): void
    {
        $this->assertInstanceOf(Ticket::class, $this->object);
    }

    public function testStatus(): void
    {
        $this->object->setStatus(TicketMessageInterface::STATUS_INVALID);
        $this->assertSame(TicketMessageInterface::STATUS_INVALID, $this->object->getStatus());
    }
}
