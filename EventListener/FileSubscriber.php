<?php

namespace Hackzilla\Bundle\TicketBundle\EventListener;

use Hackzilla\Bundle\TicketBundle\Model\MessageAttachmentInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Event as VichEvent;

/**
 * Class FileSubscriber.
 *
 * Source: https://gist.github.com/hubgit/0cdf96c296f20017fe91#file-filesubscriber-php
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

    /**
     * @param VichEvent\Event $event
     */
    public function postUpload(VichEvent\Event $event)
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
