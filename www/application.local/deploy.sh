cp .env-example .env
sed -i -- "s|%POSTGRES_USER%|$1|g" .env
sed -i -- "s|%POSTGRES_PASSWORD%|$2|g" .env
sed -i -- "s|%POSTGRES_HOST%|$3|g" .env
sed -i -- "s|%POSTGRES_DB%|$4|g" .env
sed -i -- "s|%POSTGRES_PORT%|$5|g" .env
