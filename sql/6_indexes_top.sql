-- отсортированные списки (по 5 значений) самых часто и редко используемых индексов

select *
from pg_stat_user_indexes
order by idx_scan desc
limit 5;

/*
+-----+----------+----------+---------------+--------------------+--------+------------+-------------+
|relid|indexrelid|schemaname|relname        |indexrelname        |idx_scan|idx_tup_read|idx_tup_fetch|
+-----+----------+----------+---------------+--------------------+--------+------------+-------------+
|16395|16401     |public    |movie          |movie_pkey          |13337693|13337693    |13337601     |
|16527|16531     |public    |movie_attribute|movie_attribute_pkey|10000056|10000056    |10000056     |
|16386|16390     |public    |hall           |hall_pkey           |600     |600         |600          |
|16404|16411     |public    |session        |session_pkey        |464     |464         |464          |
|16475|16482     |public    |ticket         |ticket_pkey         |323     |914         |914          |
+-----+----------+----------+---------------+--------------------+--------+------------+-------------+
*/

select *
from pg_stat_user_indexes
order by idx_scan
limit 5;

/*
+-----+----------+----------+---------+---------------------------------------+--------+------------+-------------+
|relid|indexrelid|schemaname|relname  |indexrelname                           |idx_scan|idx_tup_read|idx_tup_fetch|
+-----+----------+----------+---------+---------------------------------------+--------+------------+-------------+
|16426|16434     |public    |seat_type|seat_type_type_key                     |0       |0           |0            |
|16437|16441     |public    |seat     |seat_pkey                              |0       |0           |0            |
|16386|16392     |public    |hall     |hall_name_key                          |0       |0           |0            |
|16404|16413     |public    |session  |session_hall_id_time_start_key         |0       |0           |0            |
|16437|16443     |public    |seat     |seat_hall_id_row_number_seat_number_key|0       |0           |0            |
+-----+----------+----------+---------+---------------------------------------+--------+------------+-------------+
*/