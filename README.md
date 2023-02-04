# Event storage in Redis/Memcache

## Setup

### Run containers
```
docker-compose up -d --build
```

### Install dependencies
```
composer install
```

## Usage

### Go to **http://mysite.local/event/**.

You can:
 - create event
 - read event
 - update event
 - delete event
 - priority search event

### Change repository

Change variable **REPOSITORY** in config.ini.

Possible values:
 - Redis
 - Memcache

Default value is "Redis"