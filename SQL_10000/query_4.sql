-- 4. Поиск 3 самых прибыльных фильмов за неделю
explain analyse
select
    m.name,
    sum(ms.price) as total_price
from
    tickets as t
    inner join movies_shows ms on t.show_id = ms.id
    inner join movies m on m.id = ms.movie_id
where
    (t.created_at::date between (current_date - INTERVAL '7 day') and current_date)
    and t.is_deleted = false
    and m.is_deleted = false
group by
    m.id
order by
    total_price desc
limit 3;

-- Limit  (cost=3995.40..3995.40 rows=3 width=130) (actual time=62.336..62.341 rows=3 loops=1)
--   ->  Sort  (cost=3995.40..3995.73 rows=132 width=130) (actual time=62.334..62.338 rows=3 loops=1)
--         Sort Key: (sum(ms.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=3991.38..3993.69 rows=132 width=130) (actual time=55.340..61.446 rows=8059 loops=1)
--               Group Key: m.id
--               ->  Sort  (cost=3991.38..3991.71 rows=132 width=126) (actual time=55.332..57.577 rows=20680 loops=1)
--                     Sort Key: m.id
--                     Sort Method: quicksort  Memory: 2363kB
--                     ->  Nested Loop  (cost=335.65..3986.73 rows=132 width=126) (actual time=1.763..51.116 rows=20680 loops=1)
--                           ->  Hash Join  (cost=335.37..3880.97 rows=264 width=8) (actual time=1.749..26.165 rows=23161 loops=1)
--                                 Hash Cond: (t.show_id = ms.id)
--                                 ->  Seq Scan on tickets t  (cost=0.00..3544.91 rows=264 width=4) (actual time=0.008..18.354 rows=23161 loops=1)
--                                       Filter: ((NOT is_deleted) AND ((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))
--                                       Rows Removed by Filter: 76839
--                                 ->  Hash  (cost=195.72..195.72 rows=11172 width=12) (actual time=1.733..1.734 rows=10000 loops=1)
--                                       Buckets: 16384  Batches: 1  Memory Usage: 558kB
--                                       ->  Seq Scan on movies_shows ms  (cost=0.00..195.72 rows=11172 width=12) (actual time=0.003..0.847 rows=10000 loops=1)
--                           ->  Index Scan using movies_pkey on movies m  (cost=0.28..0.40 rows=1 width=122) (actual time=0.001..0.001 rows=1 loops=23161)
--                                 Index Cond: (id = ms.movie_id)
--                                 Filter: (NOT is_deleted)
--                                 Rows Removed by Filter: 0
-- Planning Time: 0.138 ms
-- Execution Time: 62.388 ms

-- Добавляем индекс по дате создания записи
CREATE INDEX idx_created_date ON tickets((created_at::date)) WHERE is_deleted = false;

-- Limit  (cost=935.02..935.03 rows=3 width=130) (actual time=46.745..46.750 rows=3 loops=1)
--   ->  Sort  (cost=935.02..935.33 rows=125 width=130) (actual time=46.744..46.747 rows=3 loops=1)
--         Sort Key: (sum(ms.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=931.21..933.40 rows=125 width=130) (actual time=40.015..45.839 rows=8206 loops=1)
--               Group Key: m.id
--               ->  Sort  (cost=931.21..931.53 rows=125 width=126) (actual time=40.006..42.026 rows=21195 loops=1)
--                     Sort Key: m.id
--                     Sort Method: quicksort  Memory: 2402kB
--                     ->  Nested Loop  (cost=342.51..926.86 rows=125 width=126) (actual time=2.479..34.864 rows=21195 loops=1)
--                           ->  Hash Join  (cost=342.23..826.62 rows=250 width=8) (actual time=2.466..10.708 rows=23424 loops=1)
--                                 Hash Cond: (t.show_id = ms.id)
--                                 ->  Bitmap Heap Scan on tickets t  (cost=6.86..490.59 rows=250 width=4) (actual time=0.542..3.531 rows=23424 loops=1)
--                                       Recheck Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE) AND (NOT is_deleted))
--                                       Heap Blocks: exact=637
--                                       ->  Bitmap Index Scan on idx_created_date  (cost=0.00..6.80 rows=250 width=0) (actual time=0.487..0.487 rows=23424 loops=1)
--                                             Index Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE))
--                                 ->  Hash  (cost=195.72..195.72 rows=11172 width=12) (actual time=1.878..1.879 rows=10000 loops=1)
--                                       Buckets: 16384  Batches: 1  Memory Usage: 558kB
--                                       ->  Seq Scan on movies_shows ms  (cost=0.00..195.72 rows=11172 width=12) (actual time=0.006..0.888 rows=10000 loops=1)
--                           ->  Index Scan using movies_pkey on movies m  (cost=0.28..0.40 rows=1 width=122) (actual time=0.001..0.001 rows=1 loops=23424)
--                                 Index Cond: (id = ms.movie_id)
--                                 Filter: (NOT is_deleted)
--                                 Rows Removed by Filter: 0
-- Planning Time: 0.275 ms
-- Execution Time: 46.790 ms
