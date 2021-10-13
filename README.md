# DataWiz - Research Data Documentation Assistant
![Symfony Version](https://img.shields.io/badge/Symfony-5.3-success?logo=symfony&style=flat-square)
![PHP Version](https://img.shields.io/badge/Php-^7.4-informational?logo=PHP&style=flat-square&logoColor=white)
![Composer Version](https://img.shields.io/badge/Composer-^2.0-informational?logo=Composer&style=flat-square&logoColor=white)
![Nodejs Version](https://img.shields.io/badge/Nodejs-14_LTS-informational?logo=node.js&style=flat-square&logoColor=white)
![MySql Version](https://img.shields.io/badge/MySql-8.0-informational?logo=mysql&style=flat-square&logoColor=white)
[![DataWiz 2 Build](https://github.com/leibniz-psychology/datawiz2/actions/workflows/cypress.yml/badge.svg?branch=master)](https://github.com/leibniz-psychology/datawiz2/actions/workflows/cypress.yml)
[![Übersetzungsstatus](http://weblate.zpid.de/widgets/datawiz/-/datawiz-2/svg-badge.svg)](http://weblate.zpid.de/engage/datawiz/)

DataWiz helps Psychologist with their research documentation. 
As web based system DataWiz is free to use by anyone and contributions are welcome.
More details of how to use DataWiz and how to contribute can be found at our homepage.

## State of this project

This is the second iteration of the DataWiz application.
For today, you can't use this code in production and changes will occur.
The first release is planed for late 2021.
You can check out the currently running [DataWiz version](https://github.com/ZPID/DataWiz/)

## Supported development environments

If you use `macos` or `ubuntu` you should have __no problems__, 
because those operating systems are used by the main contributors.
For those who wanna use `windows`, please consider running __Windows Subsystem For Linux__ (_WSL_).
While there is no intention to maintain any `windows` specific configuration from our side, 
you are still welcome to contribute and maintain those changes.

## Development requirements

To start developing you will need a local installation of `php`, `composer`, `nodejs (and yarn)`, `make`, `core utils`, `awk`, and the `symfony cli`.
Please consider our recommended versions, 
if you encouter any problems running a development instance of DataWiz.
With those in your `$PATH` you can run the following commands to see a running application:

```sh
make run # start developing with webpack live recompile
make stop # stop the local web server 
```

## Deployment

DataWiz depends on multiple big vendors.
- All metadata is stored in a **MySql/MariaDB**.
- The Single Sign On requires a running **Keycloak**.
- The research data is send to **Minio**, an free S3 clone. 

A full production deployment is therefore a complicated process, which is beyond the scope of this repository.
The `makefile` is intended as local solution and shouldn't be used to deploy the application.
If you still wish to deploy DataWiz yourself, please contact our IT-Service department for further information and available ressources.
Consider before your deployment, that we offer a production instance free of charge under our product portfolio.


## How to get help?

If you are new to the codebase, there are multiple resources provided for you to learn.

- Many decision made within development are explained and/or discussed within our [issue](https://github.com/leibniz-psychology/datawiz2/issues) pages.
- The most important concepts are explained in the projects [wiki](https://github.com/leibniz-psychology/datawiz2/wiki) page.
- Run `make help` to see all actions available for this project. It can run migrations, fixtures and even run the application for you.


