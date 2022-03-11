# What is it 
Webserver based on Docker: running Nginx, PHP-FPM, MySQL, Memcached, Redis in containers

# Task source
Otus PHP Pro course: https://fas.st/wRyRs  
Lesson 1: Create Docker container sample

# Author
Mikhail Ikonnikov <mishaikon@gmail.com>

# Source 
Based on original sources:
* https://github.com/ipanardian/docker-php-nginx-mysql-memcached
* https://developpaper.com/docker-quickly-builds-and-evolves-a-php-nginx-mysql-redis-xdebug-memcached-development-environment/

# How to run
docker build -t mishaikon/php71:latest -f DockerfilePhp71 .
docker-compose -f ./docker-compose.yml up

# How to stop
docker-compose down

# Check that all works
Open in browser: http://localhost:8081/index.php 