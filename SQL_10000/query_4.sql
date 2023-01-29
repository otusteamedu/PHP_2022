-- количество фильмов по цене 350
explain
select count(m.*)
from movies as m
inner join movies_shows ms on m.id = ms.movie_id
where ms.price = 350;

-- Aggregate  (cost=617.25..617.26 rows=1 width=8)
--   ->  Hash Join  (cost=215.38..615.98 rows=510 width=197)
--         Hash Cond: (m.id = ms.movie_id)
--         ->  Seq Scan on movies m  (cost=0.00..358.00 rows=10000 width=201)
--         ->  Hash  (cost=209.00..209.00 rows=510 width=4)
--               ->  Seq Scan on movies_shows ms  (cost=0.00..209.00 rows=510 width=4)
--                     Filter: (price = 350)


CREATE INDEX idx_price ON movies_shows(price);

-- Aggregate  (cost=506.86..506.87 rows=1 width=8)
--            ->  Hash Join  (cost=104.99..505.59 rows=510 width=197)
--         Hash Cond: (m.id = ms.movie_id)
--         ->  Seq Scan on movies m  (cost=0.00..358.00 rows=10000 width=201)
--         ->  Hash  (cost=98.61..98.61 rows=510 width=4)
--               ->  Bitmap Heap Scan on movies_shows ms  (cost=8.24..98.61 rows=510 width=4)
--                     Recheck Cond: (price = 350)
--                     ->  Bitmap Index Scan on idx_price  (cost=0.00..8.11 rows=510 width=0)
--                           Index Cond: (price = 350)
