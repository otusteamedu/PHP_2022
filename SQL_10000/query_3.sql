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

-- Sort  (cost=420.79..420.84 rows=22 width=161) (actual time=1.503..1.531 rows=175 loops=1)
-- "  Sort Key: h.name, ms.start_date"
--   Sort Method: quicksort  Memory: 43kB
--   ->  Nested Loop  (cost=0.44..420.30 rows=22 width=161) (actual time=0.023..1.412 rows=175 loops=1)
--         ->  Nested Loop  (cost=0.16..264.68 rows=25 width=130) (actual time=0.020..1.056 rows=200 loops=1)
--               ->  Seq Scan on movies_shows ms  (cost=0.00..259.00 rows=50 width=16) (actual time=0.011..0.987 rows=200 loops=1)
--                     Filter: ((NOT is_deleted) AND ((start_date)::date = CURRENT_DATE))
--                     Rows Removed by Filter: 9800
--               ->  Memoize  (cost=0.16..1.14 rows=1 width=122) (actual time=0.000..0.000 rows=1 loops=200)
--                     Cache Key: ms.hall_id
--                     Cache Mode: logical
--                     Hits: 197  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--                     ->  Index Scan using halls_pkey on halls h  (cost=0.15..1.12 rows=1 width=122) (actual time=0.002..0.002 rows=1 loops=3)
--                           Index Cond: (id = ms.hall_id)
--                           Filter: (NOT is_deleted)
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..6.22 rows=1 width=31) (actual time=0.001..0.001 rows=1 loops=200)
--               Index Cond: (id = ms.movie_id)
--               Filter: (NOT is_deleted)
--               Rows Removed by Filter: 0
-- Planning Time: 0.206 ms
-- Execution Time: 1.566 ms

-- Добавляем индекс по дате начала показа, причем только для неудаленных записей
CREATE INDEX idx_current_date ON movies_shows((start_date::date)) WHERE is_deleted = false;

-- Sort  (cost=243.61..243.67 rows=22 width=161) (actual time=0.705..0.712 rows=175 loops=1)
-- "  Sort Key: h.name, ms.start_date"
--   Sort Method: quicksort  Memory: 43kB
--   ->  Nested Loop  (cost=5.12..243.12 rows=22 width=161) (actual time=0.042..0.566 rows=175 loops=1)
--         ->  Nested Loop  (cost=4.83..87.51 rows=25 width=130) (actual time=0.038..0.199 rows=200 loops=1)
--               ->  Bitmap Heap Scan on movies_shows ms  (cost=4.68..81.83 rows=50 width=16) (actual time=0.030..0.128 rows=200 loops=1)
--                     Recheck Cond: (((start_date)::date = CURRENT_DATE) AND (NOT is_deleted))
--                     Heap Blocks: exact=73
--                     ->  Bitmap Index Scan on idx_current_date  (cost=0.00..4.66 rows=50 width=0) (actual time=0.022..0.022 rows=200 loops=1)
--                           Index Cond: ((start_date)::date = CURRENT_DATE)
--               ->  Memoize  (cost=0.16..1.14 rows=1 width=122) (actual time=0.000..0.000 rows=1 loops=200)
--                     Cache Key: ms.hall_id
--                     Cache Mode: logical
--                     Hits: 197  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--                     ->  Index Scan using halls_pkey on halls h  (cost=0.15..1.12 rows=1 width=122) (actual time=0.002..0.002 rows=1 loops=3)
--                           Index Cond: (id = ms.hall_id)
--                           Filter: (NOT is_deleted)
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..6.22 rows=1 width=31) (actual time=0.002..0.002 rows=1 loops=200)
--               Index Cond: (id = ms.movie_id)
--               Filter: (NOT is_deleted)
--               Rows Removed by Filter: 0
-- Planning Time: 0.317 ms
-- Execution Time: 0.749 ms
