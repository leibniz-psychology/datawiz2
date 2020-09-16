# DataWiz - Research Data Documentation Assistant
![Maintenance](https://img.shields.io/maintenance/yes/2020)


DataWiz helps Psychologist with their research documentation. 
As web based system DataWiz is free to use by anyone and contributions are welcome.
More details of how to use DataWiz and how to contribute can be found at our homepage.

## State of this project

This is the second iteration of the DataWiz application.
For today, you can't use this code in production and changes will occur.

## Supported development environments

If you use `macos` or `ubuntu` you should have __no problems__, 
because those operating systems are used by the main contributors.
For those who wanna use `windows`, please consider running __Windows Subsystem For Linux__ (_WSL_).
While there is no intention to maintain any `windows` specific configuration from our side, 
you are still welcome to contribute and maintain those changes.

## Installation

To start developing you will need a local installation of `php`, `nodejs (and npm)`, `make`, `core utils`, `awk`, `ansible` and the `symfony cli`.
With those in your `$PATH` you can run the following commands to see a running application:

```sh
make install # will setup everything for you
# a warning could occur, if you have no migrations yet (very likely)
make run # applies all changes and starts a dev server

```

## How to get help?

If you are new to the codebase, there are multiple resources provided for you to learn.

- Many decision made within development are explained and/or discussed within our [issue](https://github.com/leibniz-psychology/datawiz2/issues) pages.
- The most important concepts are explained in the projects [wiki](https://github.com/leibniz-psychology/datawiz2/wiki) page.
- Run `make` to see all actions available for this project. It can run migrations, fixtures and even deploy the application for you.
