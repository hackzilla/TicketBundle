# Ticketing Bundle v3

Simple ticketing bundle for any project.
Available translations for:
 * English
 * French
 * German
 * Italian
 * Portuguese
 * Russian
 * Spanish

[![Build Status](https://travis-ci.org/hackzilla/TicketBundle.png?branch=master)](https://travis-ci.org/hackzilla/TicketBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/091d37a9-7862-4365-952c-814ce95c4d6c/mini.png)](https://insight.sensiolabs.com/projects/091d37a9-7862-4365-952c-814ce95c4d6c)


## Requirements

* PHP >= 5.6
* [Symfony][1] ^2.8|^3.0|^4.0
* [Knp Paginator bundle][2]
* [Bootstrap v3][3] (optional) see: [http://symfony.com/blog/new-in-symfony-2-6-bootstrap-form-theme][4]

## Optional Requirements

* [FOSUserBundle][5]


## Version Matrix

| Ticket Bundle     | Symfony         | PHP   |
| ------------------| --------------- | ----- |
| [3.x][6] (master) | ^2.8\|^3.0\|^4.0 | >=5.6 |
| [2.x][7]          | ^2.7\|^3.0      | >=5.3 |
| [1.x][8]          | ^2.3            | >=5.3 |
| [0.x][9]          | ^2.3            | >=5.3 |


## Demo

See [Ticket Bundle Demo App][10] for an example installation. This can also be used for confirming bugs.


## Setup

* [Installation with FOSUserBundle][11]
* [Generic Installation][12]


## Optional Features

These optional features that can be turned on or off.

### Features

* [Attachments][13]
* [Custom Entities][14]
* [Events][15]

# 3rd Party Extensions

# [Email Notification][16]

## Configure your entities

```yaml
# config.yml

hackzilla_ticket:
    user_class: AppBundle\Entity\User
    ticket_class: AppBundle\Entity\TicketWithAttachment
    message_class: AppBundle\Entity\TicketMessageWithAttachment
```

## Custom Templates (Optional)

```yaml
# config.yml

hackzilla_ticket:
    templates:
        index: 'YOURTicketBundle:Ticket:index.html.twig'
        new: 'YOURTicketBundle:Ticket:new.html.twig'
        prototype: 'YOURTicketBundle:Ticket:prototype.html.twig'
        show: 'YOURTicketBundle:Ticket:show.html.twig'
        show_attachment: 'YOURTicketBundle:Ticket:show_attachment.html.twig'
```

## Migrate a Previous Version

* [How to migrate][17]


## Pull Requests

I'm open to pull requests for additional languages, features and/or improvements.

[1]: https://symfony.com/
[2]: https://github.com/KnpLabs/KnpPaginatorBundle
[3]: http://getbootstrap.com/docs/3.3/
[4]: http://symfony.com/blog/new-in-symfony-2-6-bootstrap-form-theme
[5]: https://symfony.com/doc/current/bundles/FOSUserBundle/index.html
[6]: https://github.com/hackzilla/TicketBundle/tree/master
[7]: https://github.com/hackzilla/TicketBundle/tree/2.x
[8]: https://github.com/hackzilla/TicketBundle/tree/1.x
[9]: https://github.com/hackzilla/TicketBundle/tree/0.9.x
[10]: https://github.com/hackzilla/TicketBundleDemoApp
[11]: Resources/doc/setup/fosuserbundle.md
[12]: Resources/doc/setup/other.md
[13]: Resources/doc/setup/feature/attachments.md
[14]: Resources/doc/setup/feature/custom-entities.md
[15]: Resources/doc/setup/feature/events.md
[16]: https://github.com/flodaq/TicketNotificationBundle
[17]: Resources/doc/migrate/index.md
