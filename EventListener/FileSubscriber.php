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

namespace Hackzilla\Bundle\TicketBundle\EventListener;

use Hackzilla\Bundle\TicketBundle\Model\TicketFeature\MessageAttachmentInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Event as VichEvent;

/**
 * Class FileSubscriber.
 *
 * Source: https://gist.github.com/hubgit/0cdf96c296f20017fe91#file-filesubscriber-php
 *
 * @final since hackzilla/ticket-bundle 3.x.
 */
class FileSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            VichEvent\Events::POST_UPLOAD => 'postUpload',
        ];
    }

    public function postUpload(VichEvent\Event $event): void
    {
        /** @var MessageAttachmentInterface $object */
        $object = $event->getObject();
        // Ignore any entity lifecycle events not relating to this bundles entities.
        if (!($object instanceof MessageAttachmentInterface)) {
            return;
        }
        $file = $object->getAttachmentFile();
        $object->setAttachmentSize($file->getSize());
        $object->setAttachmentMimeType($file->getMimeType());
    }
}
