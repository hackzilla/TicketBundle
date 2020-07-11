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

namespace Hackzilla\Bundle\TicketBundle\Tests\Form\Type;

use Hackzilla\Bundle\TicketBundle\Form\Type\StatusType;
use Symfony\Component\Form\Test\TypeTestCase;

final class StatusTypeTest extends TypeTestCase
{
    private $object;

    protected function setUp(): void
    {
        $this->object = new StatusType();
    }

    protected function tearDown(): void
    {
        $this->object = null;
    }

    public function testObjectCreated(): void
    {
        $this->assertInstanceOf(StatusType::class, $this->object);
    }
}
