-- Самые часто используемые пользовательские индексы
select indexrelname, relname, idx_scan
from pg_stat_user_indexes
order by idx_scan desc
limit 5;

-- Самые редко используемые пользовательские индексы
select indexrelname, relname, idx_scan
from pg_stat_user_indexes
order by idx_scan
limit 5;