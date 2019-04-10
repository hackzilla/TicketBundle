<?php

namespace Hackzilla\Bundle\TicketBundle\Command;

use Hackzilla\Bundle\TicketBundle\Model\TicketMessage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TicketManagerCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'ticket:create';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(static::$defaultName) // BC for symfony/console < 3.4.0
            ->setDescription('Create a new Ticket')
            ->addArgument(
                'subject',
                InputArgument::REQUIRED,
                'Enter a subject'
            )
            ->addArgument(
                'message',
                InputArgument::REQUIRED,
                'Enter the message'
            )
            ->addOption(
                'priority',
                'p',
                InputOption::VALUE_OPTIONAL,
                'What priority would it be?',
                '21'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userManager = $this->getContainer()->get('fos_user.user_manager');

        $ticketManager = $this->getContainer()->get('hackzilla_ticket.ticket_manager');

        $ticket = $ticketManager->createTicket()
            ->setSubject($input->getArgument('subject'));

        $message = $ticketManager->createMessage()
            ->setMessage($input->getArgument('message'))
            ->setStatus(TicketMessage::STATUS_OPEN)
            ->setPriority($input->getOption('priority'))
            ->setUser($userManager->findUserByUsername('system'));

        $ticketManager->updateTicket($ticket, $message);

        $output->writeln(
            "Ticket with subject '".$ticket->getSubject()."' has been created with ticketnumber #".$ticket->getId().''
        );
    }
}
