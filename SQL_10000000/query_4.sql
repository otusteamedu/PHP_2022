-- 4. Поиск 3 самых прибыльных фильмов за неделю
explain
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

-- Limit  (cost=203193.55..203193.55 rows=3 width=38)
--        ->  Sort  (cost=203193.55..203305.93 rows=44954 width=38)
--         Sort Key: (sum(ms.price)) DESC
--         ->  Finalize HashAggregate  (cost=202162.99..202612.53 rows=44954 width=38)
--               Group Key: m.id
--               ->  Gather  (cost=199121.93..202030.77 rows=26444 width=38)
--                     Workers Planned: 1
--                     ->  Partial HashAggregate  (cost=198121.93..198386.37 rows=26444 width=38)
--                           Group Key: m.id
--                           ->  Parallel Hash Join  (cost=194511.63..197989.71 rows=26444 width=34)
--                                 Hash Cond: (m.id = ms.movie_id)
--                                 ->  Parallel Seq Scan on movies m  (cost=0.00..3171.24 rows=52886 width=30)
--                                       Filter: (NOT is_deleted)
--                                 ->  Parallel Hash  (cost=194251.22..194251.22 rows=20833 width=8)
--                                       ->  Parallel Hash Join  (cost=178538.75..194251.22 rows=20833 width=8)
--                                             Hash Cond: (ms.id = t.show_id)
--                                             ->  Parallel Seq Scan on movies_shows ms  (cost=0.00..12500.67 rows=416667 width=12)
--                                             ->  Parallel Hash  (cost=178278.33..178278.33 rows=20833 width=4)
--                                                   ->  Parallel Seq Scan on tickets t  (cost=0.00..178278.33 rows=20833 width=4)
--                                                         Filter: ((NOT is_deleted) AND ((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))
-- JIT:
--   Functions: 28
--   Options: Inlining false, Optimization false, Expressions true, Deforming true


-- Добавляем индекс по дате создания записи
CREATE INDEX idx_created_date ON tickets((created_at::date)) WHERE is_deleted = false;

-- Limit  (cost=88921.80..88921.80 rows=3 width=38)
--        ->  Sort  (cost=88921.80..89034.18 rows=44954 width=38)
--         Sort Key: (sum(ms.price)) DESC
--         ->  Finalize HashAggregate  (cost=87891.23..88340.77 rows=44954 width=38)
--               Group Key: m.id
--               ->  Gather  (cost=84850.17..87759.01 rows=26444 width=38)
--                     Workers Planned: 1
--                     ->  Partial HashAggregate  (cost=83850.17..84114.61 rows=26444 width=38)
--                           Group Key: m.id
--                           ->  Parallel Hash Join  (cost=80239.88..83717.95 rows=26444 width=34)
--                                 Hash Cond: (m.id = ms.movie_id)
--                                 ->  Parallel Seq Scan on movies m  (cost=0.00..3171.24 rows=52886 width=30)
--                                       Filter: (NOT is_deleted)
--                                 ->  Parallel Hash  (cost=79979.46..79979.46 rows=20833 width=8)
--                                       ->  Parallel Hash Join  (cost=64266.99..79979.46 rows=20833 width=8)
--                                             Hash Cond: (ms.id = t.show_id)
--                                             ->  Parallel Seq Scan on movies_shows ms  (cost=0.00..12500.67 rows=416667 width=12)
--                                             ->  Parallel Hash  (cost=64006.58..64006.58 rows=20833 width=4)
--                                                   ->  Parallel Bitmap Heap Scan on tickets t  (cost=684.94..64006.58 rows=20833 width=4)
--                                                         Recheck Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE) AND (NOT is_deleted))
--                                                         ->  Bitmap Index Scan on idx_created_date  (cost=0.00..672.44 rows=50000 width=0)
--                                                               Index Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE))

