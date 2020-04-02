# WP Multisite Campaigns

A multisite installation for MoJ campaign websites

## Features

- Based on [roots/bedrock](https://roots.io/bedrock)
- Dependency management with [Composer](https://getcomposer.org)
- Enhanced password hashing using bcrypt
- Builds into a docker image
- Docker-compose is used to run as a local development server

## Requirements

- PHP >= 7.2
- Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- Docker & docker-compose - [Install](https://www.docker.com/docker-mac)
- Dory (docker proxy for local development) - [Install](https://github.com/FreedomBen/dory)

## Getting Started

1. Clone this repo to your local machine and change directories.
    ```bash
    git clone git@github.com:ministryofjustice/wp-ms-campaigns.git .
    cd wp-ms-campaigns/
    ```

2. Build the project locally. This will install composer dependencies on your local filesystem.
    ```bash
    make build
    ```

    If you experience any errors at this point, it may be due to being unable to access the private composer repository. [More details here](#private-composer-repository).

3. Start the dory proxy, if it's not already running.
    ```bash
    dory up
    ```

    If you get an error message when trying to start dory, make sure you have docker running.

4. Build and run the docker image.
    ```bash
    make run
    ```
5. Launch the website in your default browser.
    ```bash
    make launch
    ```

6. If this is a new install you may get a development replica by executing the WASM utility.
    ```bash
    wasm migrate ms-campaigns:dev .
    ```

   The WordPress admin area will be accessible at `/wp-admin`.

## Composer + WordPress plugins

The installation of WordPress core and plugins is managed by composer.

See `composer.json` for the required packages.

Plugins in the [WordPress plugin repository](https://wordpress.org/plugins/) are available from [WordPress Packagist](https://wpackagist.org/) (wpackagist).

Premium and custom plugins used by MOJ are available in the private composer repository [composer.wp.dsd.io](https://composer.wp.dsd.io).

### WordPress Packagist plugins

Wpackagist plugins are named by their slug on the WordPress plugin repository, prefixed with the vendor `wpackagist-plugin`.

Some examples:

| Plugin name | WordPress plugin URL                         | URL slug      | package name                      |
| ----------- | -------------------------------------------- | ------------- | --------------------------------- |
| Akismet     | https://wordpress.org/plugins/akismet/       | akismet       | `wpackagist-plugin/akismet`       |
| Hello Dolly | https://wordpress.org/plugins/hello-dolly/   | hello-dolly   | `wpackagist-plugin/hello-dolly`   |
| Yoast SEO   | https://wordpress.org/plugins/wordpress-seo/ | wordpress-seo | `wpackagist-plugin/wordpress-seo` |

#### Example: Installing Akismet plugin

Run the following command:

```
composer require "wpackagist-plugin/akismet" "*"
```

This will install the latest version of [Akismet](https://wordpress.org/plugins/akismet/) using the corresponding [wpackagist package](https://wpackagist.org/search?q=akismet).

### Private composer repository

The private composer repository [composer.wp.dsd.io](https://composer.wp.dsd.io) contains premium and custom WordPress plugins.

Access to this repository is restricted. Refer to internal documentation for further details.

### Building theme assets

Theme assets can be built as part of the docker image. Add required commands to `bin/build.sh`.

### Configure the default theme

Set your theme as the default by adding the following line to `config/application.php`:

```php
define('WP_DEFAULT_THEME', 'clarity');
```

## WP-CLI

The [WordPress CLI](https://wp-cli.org/) is a useful tool for running commands against your WordPress installation.

To use WP-CLI, your docker container must already be running. (This will probably be running in a separate terminal session/tab.)

1. Run:
    ```bash
    make bash
    ```

    A bash session will be opened in the running container.

2. The WP-CLI will be available as `wp`.

    For example, to list all users in the install:
    ```bash
    wp user list
    ```

## Email delivery

When running locally for development, emails sent by WordPress are not delivered. Instead they are captured by [mailcatcher](https://mailcatcher.me/).

To see emails, go to http://mail.`SERVER_NAME` (i.e. the hostname set in your `.env` file) in your browser.
e.g. http://mail.example.docker

This will load a webmail-like interface and display all emails that WordPress has sent.

## Make commands

There are several `make` commands configured in the `Makefile`. These are mostly just convenience wrappers for longer or more complicated commands.

| Command             | Description                                                                                                                                                                                          |
| ------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `make build`        | Run the build script to install application dependencies and build theme assets. This will typically involve installing composer packages and compiling SASS stylesheets.                            |
| `make clean`        | Alias of `git clean -xdf`. Restore the git working copy to its original state. This will remove uncommitted changes and ignored files.                                                               |
| `make docker-clean` | Launches an assistive script to remove docker image caches and persistent data during development. Options: v = Clean volumes. vr = Clean volumes, rebuild and run. n =  Nuke all local Docker images|
| `make run`          | Alias of `docker-compose up`. Launch the application locally using `docker-compose`.                                                                                                                 |
| `make down`         | Alias of `docker-compose down`.                                                                                                                                                                      |
| `make bash`         | Open a bash shell on the WordPress docker container. The [WP-CLI](https://wp-cli.org/) is accessible as `wp`. The application must already be running (e.g. via `make run`) before this can be used. |
| `make launch`       | Checks if the intranet docker instance is running; if not, launch docker in the background and open the site in the systems default browser                                                          |
| `make test`         | Run tests on the application. Out of the box this will run PHP CodeSniffer (code linter).                                                                                                            |
| `make test-fixes`   | Fix issues found during `make test`                                                                                                                                                                  |

## IP whitelisting

The Intranet manages IP whitelisting in a different way to most other deployments. In March 2020 authentication via IdP
was introduced to present access to the MoJ wider network and as a result, IP whitelists moved to AWS ALB listener rules.

To help manage ALB rule creation 2 scripts are available in the JotW LastPass account.

## Bedrock

This project is based on Bedrock. Therefore, much of the Bedrock documentation will be applicable. Bedrock documentation is available at [https://roots.io/bedrock/docs/](https://roots.io/bedrock/docs/).
