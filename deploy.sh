sudo cp deploy/nginx.conf /etc/nginx/conf.d/demo.conf -f
sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/demo.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/demo.conf
sudo service nginx restart
sudo -u www-data composer install -q
sudo service php8.1-fpm restart
sudo -u www-data sed -i -- "s|%RABBITMQ_HOST%|$2|g" .env
sudo -u www-data sed -i -- "s|%RABBITMQ_USER%|$3|g" .env
sudo -u www-data sed -i -- "s|%RABBITMQ_PASSWORD%|$4|g" .env
sudo -u www-data sed -i -- "s|%MEMCACHED_HOST%|$5|g" .env
sudo -u www-data sed -i -- "s|%MEMCACHED_PORT%|$6|g" .env
sudo service memcached restart
sudo service supervisor restart
