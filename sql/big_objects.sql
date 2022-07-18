-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
select table_name as object, pg_relation_size(quote_ident(table_name)) as size
from information_schema.tables
where table_schema = 'public'
union all
select indexname as object, pg_indexes_size(quote_ident(tablename)) as size
from pg_indexes
order by size desc
limit 15;

/*
object	size
ticket_pkey	763346944
ticket_session_id_place_id_idx	763346944
ticket_session_id_idx	763346944
ticket_full_price_idx	763346944
ticket	468934656
session_time_idx	52256768
session_pkey	52256768
session_film_id_idx	52256768
session	52183040
hall_session	36249600
customer	6643712
customer_pkey	3391488
pg_depend_depender_index	835584
pg_depend_reference_index	835584
pg_proc_proname_args_nsp_index	352256
 */