-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
explain analyse
select
    p.line,
    p.number,
    CASE WHEN t.id is null THEN false ELSE true END AS busy
from
    halls_places as p
    left join tickets t on (p.id = t.place_id and t.show_id = 10)
order by
    p.line, p.number;

-- Sort  (cost=117096.30..117099.90 rows=1440 width=9) (actual time=244.614..245.096 rows=1440 loops=1)
-- "  Sort Key: p.line, p.number"
--   Sort Method: quicksort  Memory: 127kB
--   ->  Nested Loop Left Join  (cost=1000.00..117020.76 rows=1440 width=9) (actual time=242.554..244.763 rows=1440 loops=1)
--         Join Filter: (p.id = t.place_id)
--         Rows Removed by Join Filter: 20146
--         ->  Seq Scan on halls_places p  (cost=0.00..25.40 rows=1440 width=12) (actual time=0.005..0.078 rows=1440 loops=1)
--         ->  Materialize  (cost=1000.00..116779.38 rows=10 width=8) (actual time=0.038..0.169 rows=14 loops=1440)
--               ->  Gather  (cost=1000.00..116779.33 rows=10 width=8) (actual time=55.105..242.959 rows=14 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Parallel Seq Scan on tickets t  (cost=0.00..115778.33 rows=4 width=8) (actual time=43.368..225.427 rows=5 loops=3)
--                           Filter: (show_id = 10)
--                           Rows Removed by Filter: 3333329
-- Planning Time: 0.284 ms
-- JIT:
--   Functions: 18
--   Options: Inlining false, Optimization false, Expressions true, Deforming true
--   Timing: Generation 1.253 ms, Inlining 0.000 ms, Optimization 0.708 ms, Emission 8.163 ms, Total 10.123 ms
-- Execution Time: 245.783 ms

-- Индекс по полю show_id
CREATE INDEX idx_show_id ON tickets(show_id);

-- Sort  (cost=163.58..167.18 rows=1440 width=9) (actual time=0.728..0.769 rows=1440 loops=1)
-- "  Sort Key: p.line, p.number"
--   Sort Method: quicksort  Memory: 127kB
--   ->  Hash Right Join  (cost=43.83..88.03 rows=1440 width=9) (actual time=0.274..0.434 rows=1440 loops=1)
--         Hash Cond: (t.place_id = p.id)
--         ->  Index Scan using idx_show_id on tickets t  (cost=0.43..44.61 rows=10 width=8) (actual time=0.014..0.049 rows=14 loops=1)
--               Index Cond: (show_id = 10)
--         ->  Hash  (cost=25.40..25.40 rows=1440 width=12) (actual time=0.255..0.255 rows=1440 loops=1)
--               Buckets: 2048  Batches: 1  Memory Usage: 78kB
--               ->  Seq Scan on halls_places p  (cost=0.00..25.40 rows=1440 width=12) (actual time=0.005..0.132 rows=1440 loops=1)
-- Planning Time: 0.238 ms
-- Execution Time: 0.814 ms
