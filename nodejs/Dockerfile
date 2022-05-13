FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    && curl https://deb.nodesource.com/setup_12.x | bash \
    && curl https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update && apt-get install -y nodejs yarn \
    && yarn add --dev @symfony/webpack-encore \
    && yarn add sass-loader@^12.0.0 sass --dev

WORKDIR /code

CMD ["php-fpm"]
