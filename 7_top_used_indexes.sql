-- отсортированные списки (по 5 значений) самых часто используемых индексов
select * from pg_stat_user_indexes order by idx_scan desc limit 5;

/*
 relid | indexrelid | schemaname | relname |           indexrelname            | idx_scan | idx_tup_read | idx_tup_fetch
-------+------------+------------+---------+-----------------------------------+----------+--------------+---------------
 25126 |      25130 | public     | hall    | hall_pk                           |      700 |          700 |           700
 25161 |      25169 | public     | user    | user_pk                           |      231 |          231 |           228
 25172 |      25182 | public     | place   | place_pk                          |      210 |          210 |           210
 25134 |      25138 | public     | movie   | movie_pk                          |      121 |          330 |           316
 25186 |      25208 | public     | order   | order_schedule_id_place_id_uindex |       32 |           38 |            18
*/

-- отсортированные списки (по 5 значений) самых редко используемых индексов
select * from pg_stat_user_indexes order by idx_scan limit 5;

/*
select * from pg_stat_user_indexes order by idx_scan limit 5;
 relid | indexrelid | schemaname | relname  |    indexrelname    | idx_scan | idx_tup_read | idx_tup_fetch
-------+------------+------------+----------+--------------------+----------+--------------+---------------
 25126 |      25132 | public     | hall     | hall_name_uindex   |        0 |            0 |             0
 25161 |      25167 | public     | user     | user_id_uindex     |        0 |            0 |             0
 25134 |      25140 | public     | movie    | movie_name_uindex  |        0 |            0 |             0
 25142 |      25156 | public     | schedule | schedule_id_uindex |        0 |            0 |             0
 25161 |      25168 | public     | user     | user_login_uindex  |        0 |            0 |             0
*/