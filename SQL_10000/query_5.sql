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

-- Sort  (cost=2005.97..2009.57 rows=1440 width=9) (actual time=6.571..6.625 rows=1440 loops=1)
-- "  Sort Key: p.line, p.number"
--   Sort Method: quicksort  Memory: 127kB
--   ->  Hash Right Join  (cost=43.40..1930.43 rows=1440 width=9) (actual time=3.134..6.267 rows=1440 loops=1)
--         Hash Cond: (t.place_id = p.id)
--         ->  Seq Scan on tickets t  (cost=0.00..1887.00 rows=10 width=8) (actual time=2.870..5.858 rows=6 loops=1)
--               Filter: (show_id = 10)
--               Rows Removed by Filter: 99994
--         ->  Hash  (cost=25.40..25.40 rows=1440 width=12) (actual time=0.256..0.259 rows=1440 loops=1)
--               Buckets: 2048  Batches: 1  Memory Usage: 78kB
--               ->  Seq Scan on halls_places p  (cost=0.00..25.40 rows=1440 width=12) (actual time=0.005..0.122 rows=1440 loops=1)
-- Planning Time: 0.233 ms
-- Execution Time: 6.677 ms

-- Индекс по полю show_id
CREATE INDEX idx_show_id ON tickets(show_id);

-- Sort  (cost=159.70..163.30 rows=1440 width=9) (actual time=0.769..0.809 rows=1440 loops=1)
-- "  Sort Key: p.line, p.number"
--   Sort Method: quicksort  Memory: 127kB
--   ->  Hash Right Join  (cost=47.77..84.16 rows=1440 width=9) (actual time=0.307..0.434 rows=1440 loops=1)
--         Hash Cond: (t.place_id = p.id)
--         ->  Bitmap Heap Scan on tickets t  (cost=4.37..40.74 rows=10 width=8) (actual time=0.020..0.030 rows=6 loops=1)
--               Recheck Cond: (show_id = 10)
--               Heap Blocks: exact=6
--               ->  Bitmap Index Scan on idx_show_id  (cost=0.00..4.37 rows=10 width=0) (actual time=0.015..0.015 rows=6 loops=1)
--                     Index Cond: (show_id = 10)
--         ->  Hash  (cost=25.40..25.40 rows=1440 width=12) (actual time=0.280..0.281 rows=1440 loops=1)
--               Buckets: 2048  Batches: 1  Memory Usage: 78kB
--               ->  Seq Scan on halls_places p  (cost=0.00..25.40 rows=1440 width=12) (actual time=0.003..0.135 rows=1440 loops=1)
-- Planning Time: 0.223 ms
-- Execution Time: 0.853 ms
