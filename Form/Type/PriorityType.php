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

namespace Hackzilla\Bundle\TicketBundle\Form\Type;

use Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @final since hackzilla/ticket-bundle 3.x.
 */
class PriorityType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $choices = TicketMessageInterface::PRIORITIES;
        unset($choices[TicketMessageInterface::PRIORITY_INVALID]);

        // Workaround for symfony/options-resolver >= 2.7, < 3.1.
        if ($resolver->hasDefault('choices_as_values') && version_compare(Kernel::VERSION, '3.1', '<')) {
            $resolver->setDefaults(['choices' => array_flip($choices), 'choices_as_values' => true]);
        } else {
            $resolver->setDefaults(['choices' => array_flip($choices)]);
        }
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix()
    {
        return 'priority';
    }
}
