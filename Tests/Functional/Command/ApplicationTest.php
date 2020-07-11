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

namespace Hackzilla\Bundle\TicketBundle\Tests\Functional\Command;

use Hackzilla\Bundle\TicketBundle\Command\AutoClosingCommand;
use Hackzilla\Bundle\TicketBundle\Command\TicketManagerCommand;
use Hackzilla\Bundle\TicketBundle\Tests\Functional\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 */
final class ApplicationTest extends WebTestCase
{
    /**
     * @dataProvider getCommands
     *
     * @param string $expectedClass
     * @param string $commandName
     */
    public function testCommandRegistration($expectedClass, $commandName)
    {
        $application = new Application(static::$kernel);

        $this->assertInstanceOf($expectedClass, $application->find($commandName));
    }

    public function getCommands()
    {
        return [
            [AutoClosingCommand::class, 'ticket:autoclosing'],
            [TicketManagerCommand::class, 'ticket:create'],
        ];
    }
}
