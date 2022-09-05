# RSS Feed Application
## Introduction

This is application provides a basic RSS feed loader. All RSS feed URLs can be saved and deleted from a local file. 
This allows you to load the feed at a later date. Furthermore, you can favor one single feed to load as 
default when opening the site.
<br>
<br>
When [api.rss2json.com](https://www.api.rss2json.com) becomes unavailable implement your own API. Parts and modules are easily replaced!

Three feeds are installed by default but can be removed from the localFeed.config.json.

## Docker
In order to use this project correctly you must install [Docker](https://www.docker.com).
<br>
This project uses my own custom [Linux PHP Docker Image](https://hub.docker.com/r/thehideout/php-8.0.2-apache-composer-xdebug).
You can create your own image with the included Dockerfile.

## Getting Started
Use
```bash
docker-compose up
```
to start the application.
<br>

## Access Web Container
You can access the web container by using
```bash
docker-compose exec rssfeed bash
```
If necessary run composer update.
<br>

## Congratulations! You can now start using the application under [RSS Feed Application](http://127.0.0.1:8080)
