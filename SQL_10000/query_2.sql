-- 2. Подсчёт проданных билетов за неделю
explain analyse
    select
        count(*)
    from
        tickets
    where
        (created_at::date between (current_date - INTERVAL '7 day') and current_date)
        and is_deleted = false;

-- Aggregate  (cost=339.13..339.14 rows=1 width=8) (actual time=2.028..2.029 rows=1 loops=1)
--   ->  Seq Scan on tickets  (cost=0.00..339.00 rows=50 width=0) (actual time=0.006..1.947 rows=2339 loops=1)
--         Filter: ((NOT is_deleted) AND ((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))
--         Rows Removed by Filter: 7661
-- Planning Time: 0.054 ms
-- Execution Time: 2.044 ms

-- Добавляем индекс по дате создания записи
CREATE INDEX idx_created_date ON tickets((created_at::date)) WHERE is_deleted = false;

-- Aggregate  (cost=69.31..69.32 rows=1 width=8) (actual time=0.320..0.320 rows=1 loops=1)
--   ->  Bitmap Heap Scan on tickets  (cost=4.81..69.18 rows=50 width=0) (actual time=0.067..0.235 rows=2339 loops=1)
--         Recheck Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE) AND (NOT is_deleted))
--         Heap Blocks: exact=64
--         ->  Bitmap Index Scan on idx_created_date  (cost=0.00..4.79 rows=50 width=0) (actual time=0.056..0.056 rows=2339 loops=1)
--               Index Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE))
-- Planning Time: 0.096 ms
-- Execution Time: 0.338 ms
