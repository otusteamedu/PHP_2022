-- отсортированный список (15 значений) самых больших по размеру объектов БД
-- (таблицы, включая индексы, сами индексы)
select table_name as object, pg_relation_size(quote_ident(table_name)) as size
from information_schema.tables
where table_schema = 'public'
union all
select indexname as object, pg_indexes_size(quote_ident(tablename)) as size
from pg_indexes
order by size desc
limit 15;

/*
+-------------------------------+---------+
|object                         |size     |
+-------------------------------+---------+
|ticket                         |695574528|
|movie                          |644186112|
|movie_attribute_value          |521789440|
|movie_duration_index           |294084608|
|movie_pkey                     |294084608|
|movie_attribute_value_date_idx |293961728|
|movie_attribute_value_pkey     |293961728|
|ticket_pkey                    |224632832|
|pg_depend_depender_index       |835584   |
|pg_depend_reference_index      |835584   |
|pg_proc_oid_index              |352256   |
|pg_proc_proname_args_nsp_index |352256   |
|pg_description_o_c_o_index     |221184   |
|pg_attribute_relid_attnum_index|221184   |
|pg_attribute_relid_attnam_index|221184   |
+-------------------------------+---------+
*/