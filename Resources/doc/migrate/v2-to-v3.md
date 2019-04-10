## Migration from v2 to v3

Any reference to `TicketMessage` constants will need to use `TicketMessageInterface`.

Previously:

```
Hackzilla\Bundle\TicketBundle\Model\TicketMessage::STATUS_OPEN
Hackzilla\Bundle\TicketBundle\Model\TicketMessage::STATUS_CLOSED
```

Will now become:

```
Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface::STATUS_OPEN
Hackzilla\Bundle\TicketBundle\Model\TicketMessageInterface::STATUS_CLOSED
```

### `TicketManagerInterface` Changes

The interface ```Hackzilla\Bundle\TicketBundle\Manager\TicketManagerInterface``` has been modified.

* Entity Manager needs passing in through `setEntityManager()`
* Translator needs passing in through `setTranslator()`
* `getTicketStatus()` and `getTicketPriority()` no longer need translator passing
* added `createMessage()` and `getMessageById()`
* `updateTicket()` now can take an optional message object.
