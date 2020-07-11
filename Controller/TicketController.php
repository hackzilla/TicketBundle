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

namespace Hackzilla\Bundle\TicketBundle\Controller;

use Hackzilla\Bundle\TicketBundle\Event\TicketEvent;
use Hackzilla\Bundle\TicketBundle\Form\Type\TicketMessageType;
use Hackzilla\Bundle\TicketBundle\Form\Type\TicketType;
use Hackzilla\Bundle\TicketBundle\Manager\UserManagerInterface;
use Hackzilla\Bundle\TicketBundle\Model\TicketInterface;
use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;
use Hackzilla\Bundle\TicketBundle\TicketEvents;
use Hackzilla\Bundle\TicketBundle\TicketRole;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ticket controller.
 *
 * @final since hackzilla/ticket-bundle 3.x.
 */
class TicketController extends Controller
{
    /**
     * Lists all Ticket entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $userManager = $this->getUserManager();
        $ticketManager = $this->get('hackzilla_ticket.ticket_manager');

        $ticketState = $request->get('state', $this->get('translator')->trans('STATUS_OPEN', [], 'HackzillaTicketBundle'));
        $ticketPriority = $request->get('priority', null);

        $query = $ticketManager->getTicketListQuery(
            $userManager,
            $ticketManager->getTicketStatus($ticketState),
            $ticketManager->getTicketPriority($ticketPriority)
        );

        $pagination = $this->get('knp_paginator')->paginate(
            $query->getQuery(),
            $request->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render(
            $this->container->getParameter('hackzilla_ticket.templates')['index'],
            [
                'pagination' => $pagination,
                'ticketState' => $ticketState,
                'ticketPriority' => $ticketPriority,
                'translationDomain' => 'HackzillaTicketBundle',
            ]
        );
    }

    /**
     * Creates a new Ticket entity.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $ticketManager = $this->get('hackzilla_ticket.ticket_manager');

        $ticket = $ticketManager->createTicket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $message = $ticket->getMessages()->current();
            $message->setStatus(TicketMessageInterface::STATUS_OPEN)
                ->setUser($this->getUserManager()->getCurrentUser());

            $ticketManager->updateTicket($ticket, $message);
            $this->dispatchTicketEvent(TicketEvents::TICKET_CREATE, $ticket);

            return $this->redirect($this->generateUrl('hackzilla_ticket_show', ['ticketId' => $ticket->getId()]));
        }

        return $this->render(
            $this->container->getParameter('hackzilla_ticket.templates')['new'],
            [
                'entity' => $ticket,
                'form' => $form->createView(),
                'translationDomain' => 'HackzillaTicketBundle',
            ]
        );
    }

    /**
     * Displays a form to create a new Ticket entity.
     */
    public function newAction()
    {
        $ticketManager = $this->get('hackzilla_ticket.ticket_manager');
        $entity = $ticketManager->createTicket();

        $form = $this->createForm(TicketType::class, $entity);

        return $this->render(
            $this->container->getParameter('hackzilla_ticket.templates')['new'],
            [
                'entity' => $entity,
                'form' => $form->createView(),
                'translationDomain' => 'HackzillaTicketBundle',
            ]
        );
    }

    /**
     * Finds and displays a TicketInterface entity.
     *
     * @param int $ticketId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($ticketId)
    {
        $ticketManager = $this->get('hackzilla_ticket.ticket_manager');
        $ticket = $ticketManager->getTicketById($ticketId);

        if (!$ticket) {
            return $this->redirect($this->generateUrl('hackzilla_ticket'));
        }

        $currentUser = $this->getUserManager()->getCurrentUser();
        $this->getUserManager()->hasPermission($currentUser, $ticket);

        $data = ['ticket' => $ticket, 'translationDomain' => 'HackzillaTicketBundle'];

        $message = $ticketManager->createMessage($ticket);

        if (TicketMessageInterface::STATUS_CLOSED != $ticket->getStatus()) {
            $data['form'] = $this->createMessageForm($message)->createView();
        }

        if ($currentUser && $this->getUserManager()->hasRole($currentUser, TicketRole::ADMIN)) {
            $data['delete_form'] = $this->createDeleteForm($ticket->getId())->createView();
        }

        return $this->render($this->container->getParameter('hackzilla_ticket.templates')['show'], $data);
    }

    /**
     * Finds and displays a TicketInterface entity.
     *
     * @param int $ticketId
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function replyAction(Request $request, $ticketId)
    {
        $ticketManager = $this->get('hackzilla_ticket.ticket_manager');
        $ticket = $ticketManager->getTicketById($ticketId);

        if (!$ticket) {
            throw $this->createNotFoundException($this->get('translator')->trans('ERROR_FIND_TICKET_ENTITY', [], 'HackzillaTicketBundle'));
        }

        $user = $this->getUserManager()->getCurrentUser();
        $this->getUserManager()->hasPermission($user, $ticket);

        $message = $ticketManager->createMessage($ticket);

        $form = $this->createMessageForm($message);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $message->setUser($user);
            $ticketManager->updateTicket($ticket, $message);
            $this->dispatchTicketEvent(TicketEvents::TICKET_UPDATE, $ticket);

            return $this->redirect($this->generateUrl('hackzilla_ticket_show', ['ticketId' => $ticket->getId()]));
        }

        $data = ['ticket' => $ticket, 'form' => $form->createView(), 'translationDomain' => 'HackzillaTicketBundle'];

        if ($user && $this->get('hackzilla_ticket.user_manager')->hasRole($user, TicketRole::ADMIN)) {
            $data['delete_form'] = $this->createDeleteForm($ticket->getId())->createView();
        }

        return $this->render($this->container->getParameter('hackzilla_ticket.templates')['show'], $data);
    }

    /**
     * Deletes a Ticket entity.
     *
     * @param int $ticketId
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $ticketId)
    {
        $userManager = $this->getUserManager();
        $user = $userManager->getCurrentUser();

        if (!\is_object($user) || !$userManager->hasRole($user, TicketRole::ADMIN)) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(403);
        }

        $form = $this->createDeleteForm($ticketId);

        if ($request->isMethod('DELETE')) {
            $form->submit($request->request->get($form->getName()));

            if ($form->isValid()) {
                $ticketManager = $this->get('hackzilla_ticket.ticket_manager');
                $ticket = $ticketManager->getTicketById($ticketId);

                if (!$ticket) {
                    throw $this->createNotFoundException($this->get('translator')->trans('ERROR_FIND_TICKET_ENTITY', [], 'HackzillaTicketBundle'));
                }

                $ticketManager->deleteTicket($ticket);
                $this->dispatchTicketEvent(TicketEvents::TICKET_DELETE, $ticket);
            }
        }

        return $this->redirect($this->generateUrl('hackzilla_ticket'));
    }

    private function dispatchTicketEvent($ticketEvent, TicketInterface $ticket): void
    {
        $event = new TicketEvent($ticket);
        $this->get('event_dispatcher')->dispatch($ticketEvent, $event);
    }

    /**
     * Creates a form to delete a Ticket entity by id.
     *
     * @param mixed $id The entity id
     */
    private function createDeleteForm($id): FormInterface
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm();
    }

    private function createMessageForm(TicketMessageInterface $message): FormInterface
    {
        $form = $this->createForm(
            TicketMessageType::class,
            $message,
            ['new_ticket' => false]
        );

        return $form;
    }

    private function getUserManager(): UserManagerInterface
    {
        return $this->get('hackzilla_ticket.user_manager');
    }
}
