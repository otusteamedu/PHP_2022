sudo cp deploy/application.conf /etc/nginx/conf.d/application.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/application.conf
sudo service nginx restart
sudo service php8.1-fpm restart