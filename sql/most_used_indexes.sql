-- отсортированные списки (по 5 значений) самых часто и редко используемых индексов

select *
from pg_stat_user_indexes
order by idx_scan desc
limit 5;

/*
 relid	indexrelid	schemaname	relname	indexrelname	idx_scan	idx_tup_read	idx_tup_fetch
33312	33333	public	ticket	ticket_session_id_place_id_idx	10000014	1011409	1011395
33312	33316	public	ticket	ticket_pkey	10000000	0	0
33263	33268	public	session	session_pkey	9988641	9988641	9988605
33298	33303	public	place	place_pkey	8988605	8988605	8988605
33276	33282	public	customer	customer_pkey	8988605	8988605	8988605
 */