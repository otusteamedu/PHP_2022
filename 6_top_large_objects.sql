-- отсортированный список (15 значений) самых больших по размеру объектов БД
-- (таблицы, включая индексы, сами индексы)
\c otus_hw11;

select table_name as object, pg_relation_size(quote_ident(table_name)) as size
from information_schema.tables
where table_schema = 'public'
union all
select indexname as object, pg_indexes_size(quote_ident(tablename)) as size
from pg_indexes
order by size desc
    limit 15;

/*
             object              |   size
---------------------------------+----------
 movie_name_uindex               | 18087936
 movie_duration_index            | 18087936
 movie_pk                        | 18087936
 i_movie_name_length             | 18087936
 user_pk                         |  1032192
 user_id_uindex                  |  1032192
 user_login_uindex               |  1032192
 pg_depend_depender_index        |   835584
 pg_depend_reference_index       |   835584
 user                            |   827392
 movie                           |   557056
 pg_proc_oid_index               |   352256
 pg_proc_proname_args_nsp_index  |   352256
 pg_description_o_c_o_index      |   221184
 pg_attribute_relid_attnam_index |   212992
*/