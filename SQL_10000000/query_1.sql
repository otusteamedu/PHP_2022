-- 1. Выбор всех фильмов на сегодня
explain analyse
    select
        m.name,
        ms.start_date,
        ms.start_date::date
    from
        movies as m
        inner join movies_shows ms on m.id = ms.movie_id
    where
        ms.start_date::date = current_date
        and ms.is_deleted = false
        and m.is_deleted = false
order by ms.start_date;

-- Gather Merge  (cost=20387.35..20691.41 rows=2644 width=38) (actual time=86.614..93.209 rows=11220 loops=1)
--   Workers Planned: 1
--   Workers Launched: 1
--   ->  Sort  (cost=19387.34..19393.95 rows=2644 width=38) (actual time=73.520..74.168 rows=5610 loops=2)
--         Sort Key: ms.start_date
--         Sort Method: quicksort  Memory: 675kB
--         Worker 0:  Sort Method: quicksort  Memory: 656kB
--         ->  Parallel Hash Join  (cost=15651.70..19237.04 rows=2644 width=38) (actual time=56.170..72.297 rows=5610 loops=2)
--               Hash Cond: (m.id = ms.movie_id)
--               ->  Parallel Seq Scan on movies m  (cost=0.00..3171.24 rows=52886 width=30) (actual time=0.098..11.197 rows=44952 loops=2)
--                     Filter: (NOT is_deleted)
--                     Rows Removed by Filter: 5048
--               ->  Parallel Hash  (cost=15625.67..15625.67 rows=2083 width=12) (actual time=55.908..55.918 rows=6271 loops=2)
--                     Buckets: 16384 (originally 8192)  Batches: 1 (originally 1)  Memory Usage: 832kB
--                     ->  Parallel Seq Scan on movies_shows ms  (cost=0.00..15625.67 rows=2083 width=12) (actual time=0.012..53.420 rows=6271 loops=2)
--                           Filter: ((NOT is_deleted) AND ((start_date)::date = CURRENT_DATE))
--                           Rows Removed by Filter: 493729
-- Planning Time: 0.412 ms
-- Execution Time: 93.480 ms


-- Добавляем индекс по дате начала показа, причем только для неудаленных записей
CREATE INDEX idx_current_date ON movies_shows((start_date::date)) WHERE is_deleted = false;

-- Gather Merge  (cost=12404.20..12708.26 rows=2644 width=38) (actual time=31.107..34.890 rows=11220 loops=1)
--   Workers Planned: 1
--   Workers Launched: 1
--   ->  Sort  (cost=11404.19..11410.80 rows=2644 width=38) (actual time=18.756..19.221 rows=5610 loops=2)
--         Sort Key: ms.start_date
--         Sort Method: quicksort  Memory: 1092kB
--         Worker 0:  Sort Method: quicksort  Memory: 335kB
--         ->  Parallel Hash Join  (cost=7668.56..11253.90 rows=2644 width=38) (actual time=6.007..17.854 rows=5610 loops=2)
--               Hash Cond: (m.id = ms.movie_id)
--               ->  Parallel Seq Scan on movies m  (cost=0.00..3171.24 rows=52886 width=30) (actual time=0.007..7.234 rows=44952 loops=2)
--                     Filter: (NOT is_deleted)
--                     Rows Removed by Filter: 5048
--               ->  Parallel Hash  (cost=7642.52..7642.52 rows=2083 width=12) (actual time=5.866..5.867 rows=6271 loops=2)
--                     Buckets: 16384 (originally 8192)  Batches: 1 (originally 1)  Memory Usage: 800kB
--                     ->  Parallel Bitmap Heap Scan on movies_shows ms  (cost=59.18..7642.52 rows=2083 width=12) (actual time=1.401..9.845 rows=12542 loops=1)
--                           Recheck Cond: (((start_date)::date = CURRENT_DATE) AND (NOT is_deleted))
--                           Heap Blocks: exact=6504
--                           ->  Bitmap Index Scan on idx_current_date  (cost=0.00..57.93 rows=5000 width=0) (actual time=0.750..0.750 rows=12542 loops=1)
--                                 Index Cond: ((start_date)::date = CURRENT_DATE)
-- Planning Time: 0.186 ms
-- Execution Time: 35.133 ms
