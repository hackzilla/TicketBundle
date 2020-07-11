# Hackzilla Ticket Bundle

Simple ticketing bundle for any project.
Available translations for:

* Dutch
* English
* French
* German
* Italian
* Portuguese
* Russian
* Spanish

[![Build Status](https://travis-ci.org/hackzilla/TicketBundle.png?branch=master)](https://travis-ci.org/hackzilla/TicketBundle)
[![Quality assurance](https://github.com/hackzilla/TicketBundle/workflows/Quality%20assurance/badge.svg)](https://github.com/hackzilla/TicketBundle/actions?query=workflow%3A%22Quality+assurance%22)
[![Lint](https://github.com/hackzilla/TicketBundle/workflows/Lint/badge.svg)](https://github.com/hackzilla/TicketBundle/actions?query=workflow%3ALint)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/091d37a9-7862-4365-952c-814ce95c4d6c/mini.png)](https://insight.sensiolabs.com/projects/091d37a9-7862-4365-952c-814ce95c4d6c)

## Requirements

* PHP ^7.3
* [Symfony][1] ^4.4
* [Knp Paginator bundle][2]

## Optional Requirements

* [FOSUserBundle][5]
* [Bootstrap v3][3] (see [http://symfony.com/blog/new-in-symfony-2-6-bootstrap-form-theme][4])

## Version Matrix

| Ticket Bundle | Symfony          | PHP        |
| --------------| ---------------- | ---------- |
| [4.x][18]     | ^4.4             | ^7.3       |
| [3.x][6]      | ^2.8\|^3.4\|^4.0 | ^5.6\|^7.0 |
| [2.x][7]      | ^2.7\|^3.4       | ^5.3\|^7.0 |
| [1.x][8]      | ^2.3             | ^5.3\|^7.0 |
| [0.x][9]      | ^2.3             | ^5.3\|^7.0 |

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

## 3rd Party Extensions

### [Email Notification][16]

### Custom Templates (Optional)

```yaml
# config/packages/hackzilla_ticket.yaml

hackzilla_ticket:
    templates:
        index: '@App/Ticket/index.html.twig'
        new: '@App/Ticket/new.html.twig'
        prototype: '@App/Ticket/prototype.html.twig'
        show: '@App/Ticket/show.html.twig'
        show_attachment: '@App/Ticket/show_attachment.html.twig'
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
[6]: https://github.com/hackzilla/TicketBundle/tree/3.x
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
[18]: https://github.com/hackzilla/TicketBundle/tree/master
