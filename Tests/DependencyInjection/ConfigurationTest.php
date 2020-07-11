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

namespace Hackzilla\Bundle\TicketBundle\Tests\DependencyInjection;

use Hackzilla\Bundle\TicketBundle\DependencyInjection\Configuration;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ConfigurationTest extends WebTestCase
{
    private $object;

    protected function setUp(): void
    {
        $this->object = new Configuration();
    }

    protected function tearDown(): void
    {
        $this->object = null;
    }

    public function testObjectCreated(): void
    {
        $this->assertInstanceOf(Configuration::class, $this->object);
    }
}
