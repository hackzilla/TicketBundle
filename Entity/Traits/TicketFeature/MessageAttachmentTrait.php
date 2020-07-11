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

namespace Hackzilla\Bundle\TicketBundle\Entity\Traits\TicketFeature;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

trait MessageAttachmentTrait
{
    /**
     * NOTE: This field is not persisted to database!
     *
     * @var File
     *
     * @Vich\UploadableField(mapping="ticket_message_attachment", fileNameProperty="attachmentName")
     */
    protected $attachmentFile;

    /**
     * @var string
     */
    protected $attachmentName;

    /**
     * @var int
     */
    protected $attachmentSize;

    /**
     * @var string
     */
    protected $attachmentMimeType;

    /**
     * {@inheritdoc}
     */
    public function setAttachmentFile(?File $file = null)
    {
        $this->attachmentFile = $file;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttachmentFile()
    {
        return $this->attachmentFile;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttachmentName($name)
    {
        $this->attachmentName = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttachmentName()
    {
        return $this->attachmentName;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttachmentSize($size)
    {
        $this->attachmentSize = $size;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttachmentSize()
    {
        return $this->attachmentSize;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttachmentMimeType($mimeType)
    {
        $this->attachmentMimeType = $mimeType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttachmentMimeType()
    {
        return $this->attachmentMimeType;
    }
}
