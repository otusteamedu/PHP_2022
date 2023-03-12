composer install
cp .env.example .env
sed -i -- "s|%POSTGRES_USER%|$1|g"
sed -i -- "s|%POSTGRES_PASSWORD%|$2|g"
sed -i -- "s|%POSTGRES_DB%|$3|g"
sed -i -- "s|%REDIS_SCHEME%|$4|g"
sed -i -- "s|%REDIS_HOST%|$5|g"
sed -i -- "s|%REDIS_PORT%|$6|g"
sed -i -- "s|%DB_DSN%|$7|g"
sed -i -- "s|%DB_USER%|$8|g"
sed -i -- "s|%DB_PASSWORD%|$9|g"
