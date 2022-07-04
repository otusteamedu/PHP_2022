-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
SELECT table_name as object, pg_relation_size(quote_ident(table_name)) as size
FROM information_schema.tables
WHERE table_schema = 'public'
UNION ALL
SELECT indexname as object, pg_indexes_size(quote_ident(tablename)) as size
FROM pg_indexes
ORDER BY size DESC
LIMIT 15;

-- отсортированные списки (по 5 значений) самых редко используемых индексов
SELECT *
FROM pg_stat_user_indexes
WHERE idx_scan = 0
ORDER BY relid DESC
LIMIT 5;

-- отсортированные списки (по 5 значений) самых часто используемых
SELECT *
FROM pg_stat_user_indexes
ORDER BY idx_scan DESC
LIMIT 5;