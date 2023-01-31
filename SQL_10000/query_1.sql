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

-- Sort  (cost=571.47..571.59 rows=45 width=38) (actual time=1.379..1.388 rows=159 loops=1)
--   Sort Key: ms.start_date
--   Sort Method: quicksort  Memory: 38kB
--   ->  Nested Loop  (cost=0.29..570.24 rows=45 width=38) (actual time=0.031..1.345 rows=159 loops=1)
--         ->  Seq Scan on movies_shows ms  (cost=0.00..259.00 rows=50 width=12) (actual time=0.014..1.020 rows=170 loops=1)
--               Filter: ((NOT is_deleted) AND ((start_date)::date = CURRENT_DATE))
--               Rows Removed by Filter: 9830
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..6.22 rows=1 width=30) (actual time=0.002..0.002 rows=1 loops=170)
--               Index Cond: (id = ms.movie_id)
--               Filter: (NOT is_deleted)
--               Rows Removed by Filter: 0
-- Planning Time: 0.226 ms
-- Execution Time: 1.421 ms


CREATE INDEX idx_current_date ON movies_shows((start_date::date)) WHERE is_deleted = false;

-- Sort  (cost=394.30..394.41 rows=45 width=38) (actual time=0.446..0.451 rows=159 loops=1)
--   Sort Key: ms.start_date
--   Sort Method: quicksort  Memory: 38kB
--   ->  Nested Loop  (cost=4.96..393.07 rows=45 width=38) (actual time=0.050..0.405 rows=159 loops=1)
--         ->  Bitmap Heap Scan on movies_shows ms  (cost=4.68..81.83 rows=50 width=12) (actual time=0.038..0.125 rows=170 loops=1)
--               Recheck Cond: (((start_date)::date = CURRENT_DATE) AND (NOT is_deleted))
--               Heap Blocks: exact=79
--               ->  Bitmap Index Scan on idx_current_date  (cost=0.00..4.66 rows=50 width=0) (actual time=0.028..0.029 rows=170 loops=1)
--                     Index Cond: ((start_date)::date = CURRENT_DATE)
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..6.22 rows=1 width=30) (actual time=0.001..0.001 rows=1 loops=170)
--               Index Cond: (id = ms.movie_id)
--               Filter: (NOT is_deleted)
--               Rows Removed by Filter: 0
-- Planning Time: 0.289 ms
-- Execution Time: 0.481 ms
