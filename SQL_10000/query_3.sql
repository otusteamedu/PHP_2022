-- 10 фильмов отсортированных по имени
explain
select id, name, duration
from movies
order by name
limit 10;

-- Limit  (cost=575.10..575.12 rows=10 width=35)
--        ->  Sort  (cost=575.10..600.10 rows=10000 width=35)
--         Sort Key: name
--         ->  Seq Scan on movies  (cost=0.00..359.00 rows=10000 width=35)


CREATE INDEX idx_name_full ON movies(name);

-- Limit  (cost=0.29..1.71 rows=10 width=35)
--        ->  Index Scan using idx_name_full on movies  (cost=0.29..1430.21 rows=10000 width=35)
