-- 6. Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
explain analyse
select
    m.name as movie,
    max(ms.price) as max_price,
    min(ms.price) as min_price
from
    movies_shows as ms
    inner join movies m on m.id = ms.movie_id
where m.id = 20
group by m.id;

-- GroupAggregate  (cost=0.29..2092.49 rows=1 width=39) (actual time=6.151..6.152 rows=1 loops=1)
--   Group Key: m.id
--   ->  Nested Loop  (cost=0.29..2092.40 rows=10 width=35) (actual time=0.023..6.145 rows=10 loops=1)
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.30 rows=1 width=31) (actual time=0.007..0.011 rows=1 loops=1)
--               Index Cond: (id = 20)
--         ->  Seq Scan on movies_shows ms  (cost=0.00..2084.00 rows=10 width=8) (actual time=0.015..6.131 rows=10 loops=1)
--               Filter: (movie_id = 20)
--               Rows Removed by Filter: 99990
-- Planning Time: 0.069 ms
-- Execution Time: 6.187 ms

-- Индекс по полю movie_id
CREATE INDEX idx_movie_id ON movies_shows(movie_id);

-- GroupAggregate  (cost=0.58..17.09 rows=1 width=39) (actual time=0.050..0.051 rows=1 loops=1)
--   Group Key: m.id
--   ->  Nested Loop  (cost=0.58..17.00 rows=10 width=35) (actual time=0.043..0.045 rows=10 loops=1)
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.30 rows=1 width=31) (actual time=0.016..0.016 rows=1 loops=1)
--               Index Cond: (id = 20)
--         ->  Index Scan using idx_movie_id on movies_shows ms  (cost=0.29..8.60 rows=10 width=8) (actual time=0.023..0.025 rows=10 loops=1)
--               Index Cond: (movie_id = 20)
-- Planning Time: 0.191 ms
-- Execution Time: 0.071 ms
