<?php

namespace Hackzilla\Bundle\TicketBundle\Model;

use Symfony\Component\HttpFoundation\File\File;

trait MessageAttachmentTrait
{
    /**
     * NOTE: This field is not persisted to database!
     *
     * @var File
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
    public function setAttachmentFile(File $file = null)
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
        $this->attachmentMimeType =  $mimeType;

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
