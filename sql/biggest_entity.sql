-- Самые большие объекты в БД среди таблиц и их индексов
select concat(table_name, ' (table + indexes)')                                             as entity_name,
       pg_relation_size(quote_ident(table_name)) + pg_indexes_size(quote_ident(table_name)) as size,
       pg_size_pretty(pg_relation_size(quote_ident(table_name)) +
                      pg_indexes_size(quote_ident(table_name)))                             as pretty_size
from information_schema.tables
where table_schema = 'public'
UNION
select concat(table_name, ' (only indexes)')    as entity_name,
       pg_indexes_size(quote_ident(table_name)) as size,
       pg_size_pretty(pg_indexes_size(quote_ident(table_name)))
from information_schema.tables
where table_schema = 'public'
order by size desc
limit 15;