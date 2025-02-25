# DataWiz - Research Data Documentation Assistant

![Symfony Version](https://img.shields.io/badge/Symfony-^7.0-success?logo=symfony&style=flat-square)
![PHP Version](https://img.shields.io/badge/Php-^8.3-informational?logo=PHP&style=flat-square&logoColor=white)
![Composer Version](https://img.shields.io/badge/Composer-^2.7-informational?logo=Composer&style=flat-square&logoColor=white)
![Nodejs Version](https://img.shields.io/badge/Nodejs-23_LTS-informational?logo=node.js&style=flat-square&logoColor=white)
![MariaDB Version](https://img.shields.io/badge/MariaDB-10.11-informational?logo=mariadb&style=flat-square&logoColor=white)
[![DataWiz 2 Build](https://github.com/leibniz-psychology/datawiz2/actions/workflows/wf-main.yml/badge.svg?branch=main)](https://github.com/leibniz-psychology/datawiz2/actions/workflows/wf-main.yml)
[![Übersetzungsstatus](http://weblate.zpid.de/widgets/datawiz/-/datawiz-2/svg-badge.svg)](http://weblate.zpid.de/engage/datawiz/)

DataWiz helps Psychologist with their research documentation.
As web based system DataWiz is free to use by anyone and contributions are welcome.
More details of how to use DataWiz and how to contribute can be found at our homepage.

## State of this project

This is the second iteration of the DataWiz application. \
For today, you can't use this code in production and changes will occur. \
You can find and test the latest version of Datawiz 2 (currently in beta) [here](https://datawiz2.dev.zpid.de/).

## Supported development environments

If you use `macos` or `ubuntu` you should have __no problems__,
because those operating systems are used by the main contributors.
For those who want to use `windows`, please consider running __Windows Subsystem For Linux__ (_WSL_).
While there is no intention to maintain any `windows` specific configuration from our side,
you are still welcome to contribute and maintain those changes.

## Development setup

To start developing you will need a local installation of
`php`, `composer`, `nodejs (and yarn)`, `make`, `core utils`, `awk` and the `symfony cli`.
Please consider our recommended versions, if you encounter any problems running a development instance of DataWiz.

### Githooks

To enable the custom project githooks run:

```shell
git config core.hooksPath .githooks
```

## Deployment

DataWiz depends on multiple vendors.

- All metadata is stored in a __MySql/MariaDB__.
- The Single Sign On requires a running __Keycloak__.

A full production deployment is therefore a complicated process, which is beyond the scope of this repository.
If you still wish to deploy DataWiz yourself, please contact our IT-Service department for further information and
available resources.
Consider before your deployment, that we offer a production instance free of charge under our product portfolio.

### Moderation

To enable the moderation for yourself, add your email address in `src/Controller/UserController.php`.
Afterwards, log into Datawiz as a normal user and navigate to `<url>/admin/install` in your browser.
You should now have admin rights.

## How to get help?

If you are new to the codebase, there are multiple resources provided for you
to learn.

- Many decision made within development are explained and/or discussed within
  our [issue](https://github.com/leibniz-psychology/datawiz2/issues) pages.
- The most important concepts are explained in the projects'
  [wiki](https://github.com/leibniz-psychology/datawiz2/wiki) page.
