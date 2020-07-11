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

namespace Hackzilla\Bundle\TicketBundle\Tests\Form\DataTransformer;

use Hackzilla\Bundle\TicketBundle\Entity\TicketMessage;
use Hackzilla\Bundle\TicketBundle\Form\DataTransformer\StatusTransformer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class StatusTransformerTest extends WebTestCase
{
    private $object;

    protected function setUp(): void
    {
        $this->object = new StatusTransformer();
    }

    protected function tearDown(): void
    {
        $this->object = null;
    }

    public function testObjectCreated(): void
    {
        $this->assertInstanceOf(StatusTransformer::class, $this->object);
    }

    public function testTransform(): void
    {
        $this->assertSame($this->object->transform(TicketMessage::STATUS_CLOSED), 1);

        $this->assertNull($this->object->transform('TEST'));
    }

    public function testReverseTransform(): void
    {
        $this->assertSame($this->object->reverseTransform(1), TicketMessage::STATUS_CLOSED);

        $this->assertNull($this->object->reverseTransform('TEST'));
    }
}
