-- отсортированные списки (по 5 значений) самых часто и редко используемых индексов

select *
from pg_stat_user_indexes
order by idx_scan desc
limit 5;

/*
relid	indexrelid	schemaname	relname	indexrelname	idx_scan	idx_tup_read	idx_tup_fetch
41382	41403	public	ticket	ticket_session_id_place_id_idx	10001998	1030714	1030700
41382	41386	public	ticket	ticket_pkey	10000000	0	0
41333	41338	public	session	session_pkey	9987132	9987132	9987114
41368	41373	public	place	place_pkey	8987114	8987114	8987114
41346	41352	public	customer	customer_pkey	8987114	8987114	8987114
 */