# Optional Feature

## Attachments

Add UploaderBundle in your composer.json:

```json
{
    "require": {
        "hackzilla/ticket-bundle": "~3.0",
        "vich/uploader-bundle": "~1.0"
    }
}
```

Specify the uploader config, so the bundle knows where to store the files.

```yaml
hackzilla_ticket:
    user_class:             AppBundle\Entity\User
    ticket_class:           AppBundle\Entity\TicketWithAttachment
    message_class:          AppBundle\Entity\TicketMessageWithAttachment
    features:
        attachment:         true

vich_uploader:
    db_driver: orm

    mappings:
        ticket_message_attachment:
            uri_prefix:         /attachment
            upload_destination: %kernel.root_dir%/../var/uploads/attachment/
```

See [VichUploaderBundle](https://github.com/dustin10/VichUploaderBundle/blob/master/Resources/doc/index.md) documentation for more details.

Don't forget to register VichUploaderBundle in AppKernel.

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Vich\UploaderBundle\VichUploaderBundle(),
        new Hackzilla\Bundle\TicketBundle\HackzillaTicketBundle(),
        // ...
        // Your application bundles
    );
}
```

## Custom Entity

If you want to implement your own entities then you will want to extend 
    
``` \Hackzilla\Bundle\TicketBundle\Model\TicketFeature\MessageAttachmentInterface ```
