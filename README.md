# php-gitlab-cli

*php-gitlab-cli* is a simple tool made to query your preferred Gitlab API from the command line.
Designed at first to facilitate the configuration of workflow automation, it can easily be use for any other uses.

API calls to Gitlab are made using the following API wrapper: https://github.com/m4tthumphrey/php-gitlab-api. 
It exposes a number of methods available on the official Gitlab API: https://docs.gitlab.com/ee/api/

For the sake of simplicity, all described parameters name in the official Gitlab API documentation have been used in *php-gitlab-cli*.
Some shortcuts commands have been added to make life even more simple.

## Getting started

You will need your Gitlab URL and an **access token**.

#### With Docker

For more convenience php-gitlab-cli is fully dockerized.

`docker run -it --env GITLAB_URL=<GITLAB_URL> --env GITLAB_TOKEN=<GITLAB_TOKEN> php-gitlab-cli <GITLAB_CLI_COMMAND>` `

#### With sources

- Copy the file *.env.dist* to .env and adjust with your settings. 

- `composer install`

- `php bin/console`

You should be up and running.

## Available commands

### Merge-requests

- `merge-request:create`
- `merge-request:update`
- `merge-request:show`
- `merge-request:list`
- `merge-request:wip`



