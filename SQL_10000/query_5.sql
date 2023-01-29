-- Сколько всего вестернов
explain
select count(m.*)
from movies as m
inner join movies_genre mg on m.id = mg.movie_id
inner join genres g on g.id = mg.genre_id
where g.name = 'Вестерн';

-- Aggregate  (cost=2091.54..2091.55 rows=1 width=8)
--            ->  Nested Loop  (cost=19.59..2090.19 rows=541 width=197)
--         ->  Hash Join  (cost=19.30..1920.30 rows=541 width=4)
--               Hash Cond: (mg.genre_id = g.id)
--               ->  Seq Scan on movies_genre mg  (cost=0.00..1637.00 rows=100000 width=8)
--               ->  Hash  (cost=19.25..19.25 rows=4 width=4)
--                     ->  Seq Scan on genres g  (cost=0.00..19.25 rows=4 width=4)
--                           Filter: ((name)::text = 'Вестерн'::text)
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..0.31 rows=1 width=201)
--               Index Cond: (id = mg.movie_id)


CREATE INDEX idx_name ON genres(name);

-- Aggregate  (cost=2492.05..2492.06 rows=1 width=8)
--            ->  Hash Join  (cost=484.20..2475.38 rows=6667 width=197)
--         Hash Cond: (mg.movie_id = m.id)
--         ->  Hash Join  (cost=1.20..1974.87 rows=6667 width=4)
--               Hash Cond: (mg.genre_id = g.id)
--               ->  Seq Scan on movies_genre mg  (cost=0.00..1637.00 rows=100000 width=8)
--               ->  Hash  (cost=1.19..1.19 rows=1 width=4)
--                     ->  Seq Scan on genres g  (cost=0.00..1.19 rows=1 width=4)
--                           Filter: ((name)::text = 'Вестерн'::text)
--         ->  Hash  (cost=358.00..358.00 rows=10000 width=201)
--               ->  Seq Scan on movies m  (cost=0.00..358.00 rows=10000 width=201)


-- @todo: скорее всего в реальных условиях будет поиск по id жанра