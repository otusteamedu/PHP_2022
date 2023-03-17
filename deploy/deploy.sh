sudo cp ../config/nginx.conf /etc/nginx/conf.d/tkt_school.conf -f
sudo cp ../config/supervisor.conf /etc/supervisor/conf.d/tkt_school.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/tkt_school.conf
sudo service nginx restart

sudo -u www-data composer install -q

sudo -u www-data sed -i -- "s|%DATABASE_HOST%|$2|g" .env
sudo -u www-data sed -i -- "s|%DATABASE_USER%|$3|g" .env
sudo -u www-data sed -i -- "s|%DATABASE_PASSWORD%|$4|g" .env
sudo -u www-data sed -i -- "s|%DATABASE_NAME%|$5|g" .env
sudo -u www-data php bin/console doctrine:migrations:migrate --no-interaction

sudo -u www-data sed -i -- "s|%RABBITMQ_HOST%|$6|g" .env
sudo -u www-data sed -i -- "s|%RABBITMQ_USER%|$7|g" .env
sudo -u www-data sed -i -- "s|%RABBITMQ_PASSWORD%|$8|g" .env
sudo service supervisor restart

sudo -u www-data php bin/console doctrine:cache:clear-query --env=prod --flush
sudo -u www-data php bin/console doctrine:cache:clear-result --env=prod --flush
sudo -u www-data php bin/console doctrine:cache:clear-metadata --env=prod --flush
sudo -u www-data php bin/console cache:warmup --env=dev



