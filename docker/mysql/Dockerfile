FROM mysql:8.0

RUN apt update && apt install -y gettext

ARG TZ
ARG TEMP_DIR
ARG DB_PORT
ARG DB_CHARSET
ARG DB_COLLASION
COPY my.tpl "/usr/local/etc/mysql/my.tpl"
RUN envsubst '$$TZ, $$TEMP_DIR, $$DB_PORT, $$DB_CHARSET, $$DB_COLLASION' < /usr/local/etc/mysql/my.tpl > /etc/mysql/conf.d/custom.cnf

ARG DB_NAME
COPY dbcreation.sql "/usr/local/etc/mysql/dbcreation.sql"
RUN envsubst '$$DB_NAME, $$DB_CHARSET' < /usr/local/etc/mysql/dbcreation.sql > /usr/local/etc/mysql/init.sql
