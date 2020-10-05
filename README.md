# DataWiz - Research Data Documentation Assistant
![Symfony Version](https://img.shields.io/badge/Symfony-4.4_LTS-blue?logo=symfony&style=flat-square)
![Nodejs Version](https://img.shields.io/badge/Nodejs-14_LTS-blue?logo=node.js&style=flat-square&logoColor=white)
![MySql Version](https://img.shields.io/badge/MySql-8.0-green?logo=mysql&style=flat-square&logoColor=white)

DataWiz helps Psychologist with their research documentation. 
As web based system DataWiz is free to use by anyone and contributions are welcome.
More details of how to use DataWiz and how to contribute can be found at our homepage.

## State of this project

This is the second iteration of the DataWiz application.
For today, you can't use this code in production and changes will occur.
The first release is planed for late 2021.

## Supported development environments

If you use `macos` or `ubuntu` you should have __no problems__, 
because those operating systems are used by the main contributors.
For those who wanna use `windows`, please consider running __Windows Subsystem For Linux__ (_WSL_).
While there is no intention to maintain any `windows` specific configuration from our side, 
you are still welcome to contribute and maintain those changes.

## Development requirements

To start developing you will need a local installation of `php`, `nodejs (and npm)`, `make`, `core utils`, `awk`, and the `symfony cli`.
With those in your `$PATH` you can run the following commands to see a running application:

```sh
make install # will setup everything for you
# a warning could occur, if you have no migrations yet (very likely)
make run # will apply all changes and starts a dev server

```
## Deployment

The `makefile` also gives you special deployment targets.
Server configuration management is a complex topic and a `makefile` alone can't handle this task.
You will need `ansible` on your development machine to use our deployment process.
Any deployments will assume an `Ubuntu 20.04.1` installation.
The process is currently not even in an alpha stage and is therefore not suitable for real work yet.
As soon as something changes about that, you will see updated information here.


## How to get help?

If you are new to the codebase, there are multiple resources provided for you to learn.

- Many decision made within development are explained and/or discussed within our [issue](https://github.com/leibniz-psychology/datawiz2/issues) pages.
- The most important concepts are explained in the projects [wiki](https://github.com/leibniz-psychology/datawiz2/wiki) page.
- Run `make help` to see all actions available for this project. It can run migrations, fixtures and even run the application for you.


