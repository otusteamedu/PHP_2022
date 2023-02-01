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

-- Limit  (cost=547.85..547.86 rows=3 width=130) (actual time=8.642..8.644 rows=3 loops=1)
--   ->  Sort  (cost=547.85..547.88 rows=14 width=130) (actual time=8.641..8.642 rows=3 loops=1)
--         Sort Key: (sum(ms.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=547.42..547.67 rows=14 width=130) (actual time=7.784..8.421 rows=1875 loops=1)
--               Group Key: m.id
--               ->  Sort  (cost=547.42..547.46 rows=14 width=126) (actual time=7.778..7.883 rows=2105 loops=1)
--                     Sort Key: m.id
--                     Sort Method: quicksort  Memory: 258kB
--                     ->  Nested Loop  (cost=0.57..547.16 rows=14 width=126) (actual time=0.031..7.314 rows=2105 loops=1)
--                           ->  Nested Loop  (cost=0.29..536.33 rows=27 width=8) (actual time=0.018..4.594 rows=2353 loops=1)
--                                 ->  Seq Scan on tickets t  (cost=0.00..356.16 rows=27 width=4) (actual time=0.012..2.073 rows=2353 loops=1)
--                                       Filter: ((NOT is_deleted) AND ((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))
--                                       Rows Removed by Filter: 7647
--                                 ->  Index Scan using movies_shows_pkey on movies_shows ms  (cost=0.29..6.67 rows=1 width=12) (actual time=0.001..0.001 rows=1 loops=2353)
--                                       Index Cond: (id = t.show_id)
--                           ->  Index Scan using movies_pkey on movies m  (cost=0.28..0.40 rows=1 width=122) (actual time=0.001..0.001 rows=1 loops=2353)
--                                 Index Cond: (id = ms.movie_id)
--                                 Filter: (NOT is_deleted)
--                                 Rows Removed by Filter: 0
-- Planning Time: 0.252 ms
-- Execution Time: 8.703 ms

-- Добавляем индекс по дате создания записи
CREATE INDEX idx_created_date ON tickets((created_at::date)) WHERE is_deleted = false;

-- Limit  (cost=375.82..375.82 rows=3 width=38) (actual time=7.366..7.368 rows=3 loops=1)
--   ->  Sort  (cost=375.82..375.93 rows=45 width=38) (actual time=7.365..7.366 rows=3 loops=1)
--         Sort Key: (sum(ms.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=374.45..375.23 rows=45 width=38) (actual time=6.502..7.149 rows=1875 loops=1)
--               Group Key: m.id
--               ->  Sort  (cost=374.45..374.56 rows=45 width=34) (actual time=6.495..6.601 rows=2105 loops=1)
--                     Sort Key: m.id
--                     Sort Method: quicksort  Memory: 258kB
--                     ->  Nested Loop  (cost=5.38..373.21 rows=45 width=34) (actual time=0.069..5.929 rows=2105 loops=1)
--                           ->  Nested Loop  (cost=5.09..352.31 rows=50 width=8) (actual time=0.060..3.057 rows=2353 loops=1)
--                                 ->  Bitmap Heap Scan on tickets t  (cost=4.81..69.18 rows=50 width=4) (actual time=0.055..0.426 rows=2353 loops=1)
--                                       Recheck Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE) AND (NOT is_deleted))
--                                       Heap Blocks: exact=64
--                                       ->  Bitmap Index Scan on idx_created_date  (cost=0.00..4.79 rows=50 width=0) (actual time=0.045..0.046 rows=2353 loops=1)
--                                             Index Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE))
--                                 ->  Index Scan using movies_shows_pkey on movies_shows ms  (cost=0.29..5.66 rows=1 width=12) (actual time=0.001..0.001 rows=1 loops=2353)
--                                       Index Cond: (id = t.show_id)
--                           ->  Index Scan using movies_pkey on movies m  (cost=0.29..0.42 rows=1 width=30) (actual time=0.001..0.001 rows=1 loops=2353)
--                                 Index Cond: (id = ms.movie_id)
--                                 Filter: (NOT is_deleted)
--                                 Rows Removed by Filter: 0
-- Planning Time: 0.258 ms
-- Execution Time: 7.403 ms
