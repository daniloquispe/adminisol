# AdminISOL

Information management system for [ISOL Perú](https://www.isolperu.com/).

## About current version

This is version 2 of AdminISOL. Original (v1) version was made using Laravel 6 and Blade template engine. For version 2,
code was reimplemented using [Laravel 10](https://laravel.com/) and [Filament 3](https://filamentphp.com/). Plus, some code conventions were
added, such as English language for all code elements (source code, database elements, routes, comments, documentation
and so on).

## Main features

* Single-user (multiple users and roles will be migrated from v1 soon)
* Domains management
* Hosting accounts management
* Organizations management (clients and vendors)
* Contacts manager
* Maintenance tables:
  * Banks
  * Bank accounts
  * Currencies
  * Hosting plan types
  * Hosting plans
  * Identification document types
  * Invoice types

## Planned features

* Integration with [WebHost Manager (WHM)](https://www.cpanel.net/products/cpanel-whm-features/) and
  [Enom](https://www.enom.com/)
* E-mail alerts for hosting and domain due dates
* Quotations management
* Invoices management

## Installation

See `INSTALL.md` file for an installation guide.
