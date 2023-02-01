-- 3. Формирование афиши (фильмы, которые показывают сегодня)
explain analyse
select
    m.name as movie,
    h.name as hall,
    ms.start_date::time as start
from
    movies as m
    inner join movies_shows ms on m.id = ms.movie_id
    inner join halls h on ms.hall_id = h.id
where
    ms.start_date::date = current_date
    and ms.is_deleted = false
    and m.is_deleted = false
    and h.is_deleted = false
order by
    h.name,
    ms.start_date;

-- Gather Merge  (cost=19369.35..19588.00 rows=1874 width=160) (actual time=61.580..66.412 rows=11220 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Sort  (cost=18369.33..18371.67 rows=937 width=160) (actual time=44.698..44.856 rows=3740 loops=3)
-- "        Sort Key: h.name, ms.start_date"
--         Sort Method: quicksort  Memory: 759kB
--         Worker 0:  Sort Method: quicksort  Memory: 407kB
--         Worker 1:  Sort Method: quicksort  Memory: 407kB
--         ->  Nested Loop  (cost=18.58..18323.08 rows=937 width=160) (actual time=0.099..42.236 rows=3740 loops=3)
--               ->  Hash Join  (cost=18.29..15649.47 rows=1042 width=130) (actual time=0.085..35.915 rows=4181 loops=3)
--                     Hash Cond: (ms.hall_id = h.id)
--                     ->  Parallel Seq Scan on movies_shows ms  (cost=0.00..15625.67 rows=2083 width=16) (actual time=0.016..35.178 rows=4181 loops=3)
--                           Filter: ((NOT is_deleted) AND ((start_date)::date = CURRENT_DATE))
--                           Rows Removed by Filter: 329153
--                     ->  Hash  (cost=15.10..15.10 rows=255 width=122) (actual time=0.010..0.011 rows=3 loops=3)
--                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                           ->  Seq Scan on halls h  (cost=0.00..15.10 rows=255 width=122) (actual time=0.007..0.008 rows=3 loops=3)
--                                 Filter: (NOT is_deleted)
--               ->  Index Scan using movies_pkey on movies m  (cost=0.29..2.56 rows=1 width=30) (actual time=0.001..0.001 rows=1 loops=12542)
--                     Index Cond: (id = ms.movie_id)
--                     Filter: (NOT is_deleted)
--                     Rows Removed by Filter: 0
-- Planning Time: 0.190 ms
-- Execution Time: 66.772 ms


-- Добавляем индекс по дате начала показа, причем только для неудаленных записей
CREATE INDEX idx_current_date ON movies_shows((start_date::date)) WHERE is_deleted = false;

-- Gather Merge  (cost=11386.21..11604.86 rows=1874 width=160) (actual time=30.514..32.877 rows=11220 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Sort  (cost=10386.19..10388.53 rows=937 width=160) (actual time=12.355..12.475 rows=3740 loops=3)
-- "        Sort Key: h.name, ms.start_date"
--         Sort Method: quicksort  Memory: 1423kB
--         Worker 0:  Sort Method: quicksort  Memory: 98kB
--         Worker 1:  Sort Method: quicksort  Memory: 100kB
--         ->  Nested Loop  (cost=77.76..10339.94 rows=937 width=160) (actual time=0.646..10.268 rows=3740 loops=3)
--               ->  Hash Join  (cost=77.47..7666.32 rows=1042 width=130) (actual time=0.627..4.555 rows=4181 loops=3)
--                     Hash Cond: (ms.hall_id = h.id)
--                     ->  Parallel Bitmap Heap Scan on movies_shows ms  (cost=59.18..7642.52 rows=2083 width=16) (actual time=0.543..3.800 rows=4181 loops=3)
--                           Recheck Cond: (((start_date)::date = CURRENT_DATE) AND (NOT is_deleted))
--                           Heap Blocks: exact=5693
--                           ->  Bitmap Index Scan on idx_current_date  (cost=0.00..57.93 rows=5000 width=0) (actual time=0.882..0.883 rows=12542 loops=1)
--                                 Index Cond: ((start_date)::date = CURRENT_DATE)
--                     ->  Hash  (cost=15.10..15.10 rows=255 width=122) (actual time=0.012..0.012 rows=3 loops=3)
--                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                           ->  Seq Scan on halls h  (cost=0.00..15.10 rows=255 width=122) (actual time=0.008..0.008 rows=3 loops=3)
--                                 Filter: (NOT is_deleted)
--               ->  Index Scan using movies_pkey on movies m  (cost=0.29..2.56 rows=1 width=30) (actual time=0.001..0.001 rows=1 loops=12542)
--                     Index Cond: (id = ms.movie_id)
--                     Filter: (NOT is_deleted)
--                     Rows Removed by Filter: 0
-- Planning Time: 0.365 ms
-- Execution Time: 33.205 ms
