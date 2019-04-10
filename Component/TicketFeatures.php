<?php

namespace Hackzilla\Bundle\TicketBundle\Component;

use Hackzilla\Bundle\TicketBundle\Model\MessageAttachmentInterface;

class TicketFeatures
{
    private $features;

    /**
     * @param array  $features
     * @param string $messageClass TicketMessage class
     */
    public function __construct(array $features, $messageClass)
    {
        if (!empty($features['attachment']) && !is_a($messageClass, MessageAttachmentInterface::class, true)
        ) {
            $features['attachment'] = false;
        }

        $this->features = $features;
    }

    /**
     * Check if feature exists or whether enabled.
     *
     * @param $feature
     *
     * @return bool|null
     */
    public function hasFeature($feature)
    {
        if (!isset($this->features[$feature])) {
            return null;
        }

        return $this->features[$feature];
    }
}
