<?php

namespace Hackzilla\Bundle\TicketBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends BaseUserInterface
{
    public function getId();

    public function getUsername();

    public function getEmail();
}
