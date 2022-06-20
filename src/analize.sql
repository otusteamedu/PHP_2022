explain
analyse
select markup
from sessions
where markup > 100;
/*
10 000 sessions
Seq Scan on sessions  (cost=0.00..209.00 rows=6678 width=5) (actual time=0.007..1.286 rows=6662 loops=1)
  Filter: (markup > '100'::numeric)
  Rows Removed by Filter: 3338
Planning Time: 0.043 ms
Execution Time: 1.471 ms
 */

/*
1 000 000 sessions
Seq Scan on sessions  (cost=0.00..20834.00 rows=667540 width=5) (actual time=0.009..103.810 rows=661882 loops=1)
 Filter: (markup > '100'::numeric)
 Rows Removed by Filter: 338118
Planning Time: 0.054 ms
Execution Time: 118.281 ms
 */

create index on sessions (markup);
/*
 10 000 sessions
 Index Only Scan using sessions_markup_idx on sessions  (cost=0.29..201.15 rows=6678 width=5) (actual time=0.022..0.544 rows=6662 loops=1)
 Index Cond: (markup > '100'::numeric)
 Heap Fetches: 0
Planning Time: 0.052 ms
Execution Time: 0.695 ms
 */

/*
 1 000 000 sessions
 Index Only Scan using sessions_markup_idx on sessions  (cost=0.42..18806.38 rows=667540 width=5) (actual time=0.048..53.071 rows=661882 loops=1)
 Index Cond: (markup > '100'::numeric)
 Heap Fetches: 0
Planning Time: 0.050 ms
Execution Time: 67.622 ms
 */

/*
 Result:
 При добавлении индекса скорость выборки увеличилась в 2 раза!
 */

SELECT table_name as object, pg_relation_size(quote_ident(table_name)) as size
FROM information_schema.tables
WHERE table_schema = 'public'
UNION ALL
SELECT indexname as object, pg_indexes_size(quote_ident(tablename)) as size
FROM pg_indexes
ORDER BY size DESC
    LIMIT 15;
