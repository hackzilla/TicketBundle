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

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Hackzilla\Bundle\TicketBundle\Manager\TicketManager;
use Hackzilla\Bundle\TicketBundle\Manager\UserManagerInterface;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 */
final class TicketManagerTest extends WebTestCase
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    protected function setUp(): void
    {
        $this->userManager = $this->createMock(UserManagerInterface::class);
        $this->userManager
            ->method('getCurrentUser')
            ->willReturn('ANONYMOUS');
    }

    protected function tearDown(): void
    {
        $this->userManager = null;
    }

    public function testGetTicketListQuery(): void
    {
        $ticketClass = 'App\Ticket';
        $ticketMessageClass = 'App\TicketMessage';

        $qb = $this->createMock(QueryBuilder::class);
        $qb
            ->method('orderBy')
            ->willReturn($qb);
        $qb
            ->method('andWhere')
            ->willReturn($qb);
        $entityRepository = $this->createMock(EntityRepository::class);
        $entityRepository
            ->method('createQueryBuilder')
            ->willReturn($qb);

        $om = $this->createMock(ObjectManager::class);
        $om
            ->method('getRepository')
            ->willReturn($entityRepository);

        $ticketManager = new TicketManager($ticketClass, $ticketMessageClass);
        $ticketManager->setEntityManager($om);

        $this->assertInstanceOf(QueryBuilder::class, $ticketManager->getTicketListQuery($this->userManager, TicketMessageInterface::STATUS_OPEN));
    }
}
