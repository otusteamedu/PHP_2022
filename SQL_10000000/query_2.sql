-- 2. Подсчёт проданных билетов за неделю
explain analyse
select
    count(*)
from
    tickets
where
    (created_at::date between (current_date - INTERVAL '7 day') and current_date)
    and is_deleted = false;

-- Finalize Aggregate  (cost=179329.15..179329.16 rows=1 width=8) (actual time=664.639..667.283 rows=1 loops=1)
--   ->  Gather  (cost=179328.94..179329.15 rows=2 width=8) (actual time=664.511..667.273 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=178328.94..178328.95 rows=1 width=8) (actual time=647.214..647.215 rows=1 loops=3)
--               ->  Parallel Seq Scan on tickets  (cost=0.00..178276.86 rows=20833 width=0) (actual time=2.936..617.355 rows=777639 loops=3)
--                     Filter: ((NOT is_deleted) AND ((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))
--                     Rows Removed by Filter: 2555694
-- Planning Time: 0.126 ms
-- JIT:
--   Functions: 14
--   Options: Inlining false, Optimization false, Expressions true, Deforming true
--   Timing: Generation 1.369 ms, Inlining 0.000 ms, Optimization 0.749 ms, Emission 7.596 ms, Total 9.714 ms
-- Execution Time: 667.845 ms

-- Добавляем индекс по дате создания записи
CREATE INDEX idx_created_date ON tickets((created_at::date)) WHERE is_deleted = false;

-- Aggregate  (cost=64933.66..64933.67 rows=1 width=8) (actual time=347.926..347.928 rows=1 loops=1)
--   ->  Bitmap Heap Scan on tickets  (cost=684.94..64808.66 rows=50000 width=0) (actual time=97.502..269.814 rows=2332917 loops=1)
--         Recheck Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE) AND (NOT is_deleted))
--         Heap Blocks: exact=63695
--         ->  Bitmap Index Scan on idx_created_date  (cost=0.00..672.44 rows=50000 width=0) (actual time=88.875..88.875 rows=2332917 loops=1)
--               Index Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE))
-- Planning Time: 0.157 ms
-- Execution Time: 347.948 ms
