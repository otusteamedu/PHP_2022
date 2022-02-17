FROM composer

ARG PROJECT_ROOT
WORKDIR ${PROJECT_ROOT}

COPY composer.* ${PROJECT_ROOT}
CMD bash -c "composer install --no-interaction"
