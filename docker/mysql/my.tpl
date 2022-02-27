[client]
port = ${DB_PORT}
default-character-set = ${DB_CHARSET}

[mysql]
default-character-set = ${DB_CHARSET}
#default_time_zone = '${TZ}'

[mysqld]
port = ${DB_PORT}
basedir = /usr
datadir = /var/lib/mysql
tmpdir = ${TEMP_DIR}
character-set-server = ${DB_CHARSET}
collation-server = ${DB_COLLASION}
max_allowed_packet = 64M
key_buffer_size = 32M
max_connections = 132
slow_query_log = 1
long_query_time = 1
expire_logs_days = 10
max_binlog_size = 100M

innodb_buffer_pool_size = 65M
innodb_log_buffer_size = 3M
innodb_log_file_size = 32M
innodb_file_per_table = 1
innodb_flush_method = O_DIRECT
innodb_flush_log_at_trx_commit = 0

sql_mode = STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION

[mysqldump]
quick
quote-names
max_allowed_packet = 64M
