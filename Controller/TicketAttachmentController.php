<?php

namespace Hackzilla\Bundle\TicketBundle\Controller;

use Hackzilla\Bundle\TicketBundle\Entity\TicketMessageWithAttachment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Ticket Attachment controller.
 *
 * Download attachments
 *
 * @final since hackzilla/ticket-bundle 3.x.
 */
class TicketAttachmentController extends Controller
{
    /**
     * Download attachment on message.
     *
     * @param int $ticketMessageId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function downloadAction($ticketMessageId)
    {
        $ticketManager = $this->get('hackzilla_ticket.ticket_manager');
        $ticketMessage = $ticketManager->getMessageById($ticketMessageId);

        if (!$ticketMessage || !$ticketMessage instanceof TicketMessageWithAttachment) {
            $translationDomain = $this->getParameter('hackzilla_ticket.translation_domain');

            throw $this->createNotFoundException($this->get('translator')->trans('ERROR_FIND_TICKET_ENTITY', [], $translationDomain));
        }

        // check permissions
        $userManager = $this->get('hackzilla_ticket.user_manager');
        $userManager->hasPermission($userManager->getCurrentUser(), $ticketMessage->getTicket());

        $downloadHandler = $this->get('vich_uploader.download_handler');

        return $downloadHandler->downloadObject($ticketMessage, 'attachmentFile');
    }
}
