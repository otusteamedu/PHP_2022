-- Получение списка из 15 самых больших по размеру объектов БД (таблицы, индексы)
SELECT table_name as object, pg_relation_size(quote_ident(table_name)) as size
FROM information_schema.tables
WHERE table_schema = 'public'
UNION ALL
SELECT indexname as object, pg_indexes_size(quote_ident(tablename)) as size
FROM pg_indexes
ORDER BY size DESC
LIMIT 15;
