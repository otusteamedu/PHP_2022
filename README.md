# PHP_2022

1. git clone git@github.com:otusteamedu/PHP_2022.git -b f_belousov/hw_12 f_belousov_hw_12
2. cd ./f_belousov_hw_12
3. cp ./.env.example .env
4. cp ./app/.env.example ./app/.env
5. docker-compose build
6. docker-compose up -d 
7. docker exec -it bf-php-fpm bash

## Commands 

 ### Add channel 
 ##### param "link" - youtube video link
 `php bin/console youtube:channel:add {link} --type=video-link`
##### example
`php bin/console youtube:channel:add https://www.youtube.com/watch?v=aViGIY4NNeM --type=video-link
`
 
 ### Sync videos with channels  
`php bin/console youtube:channel:sync-videos
`
 
### display statistics by channel
##### example
`php bin/console youtube:channel:statistics
`
 