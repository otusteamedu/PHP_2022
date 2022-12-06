-- Запрос
analyse movie_attribute_value;
analyse movie_attribute;
explain select count(value_text)
from movie_attribute_value mav
inner join movie_attribute ma on ma.id = mav.attribute_id
where ma.name = 'reviews';

-- План при 10 000 строк
-- +-----------------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                               |
-- +-----------------------------------------------------------------------------------------+
-- |Aggregate  (cost=196.01..196.02 rows=1 width=8)                                          |
-- |  ->  Nested Loop  (cost=0.00..181.01 rows=6000 width=11)                                |
-- |        Join Filter: (mav.attribute_id = ma.id)                                          |
-- |        ->  Seq Scan on movie_attribute ma  (cost=0.00..1.01 rows=1 width=4)             |
-- |              Filter: ((name)::text = 'reviews'::text)                                   |
-- |        ->  Seq Scan on movie_attribute_value mav  (cost=0.00..105.00 rows=6000 width=15)|
-- +-----------------------------------------------------------------------------------------+

-- План при 10 000 000 строк
-- +-------------------------------------------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                                                         |
-- +-------------------------------------------------------------------------------------------------------------------+
-- |Finalize Aggregate  (cost=110744.76..110744.77 rows=1 width=8)                                                     |
-- |  ->  Gather  (cost=110744.55..110744.76 rows=2 width=8)                                                           |
-- |        Workers Planned: 2                                                                                         |
-- |        ->  Partial Aggregate  (cost=109744.55..109744.56 rows=1 width=8)                                          |
-- |              ->  Hash Join  (cost=1.02..103494.50 rows=2500020 width=11)                                          |
-- |                    Hash Cond: (mav.attribute_id = ma.id)                                                          |
-- |                    ->  Parallel Seq Scan on movie_attribute_value mav  (cost=0.00..69118.20 rows=2500020 width=15)|
-- |                    ->  Hash  (cost=1.01..1.01 rows=1 width=4)                                                     |
-- |                          ->  Seq Scan on movie_attribute ma  (cost=0.00..1.01 rows=1 width=4)                     |
-- |                                Filter: ((name)::text = 'reviews'::text)                                           |
-- |JIT:                                                                                                               |
-- |  Functions: 15                                                                                                    |
-- |  Options: Inlining false, Optimization false, Expressions true, Deforming true                                    |
-- +-------------------------------------------------------------------------------------------------------------------+

-- Оптимизации
create index movie_attribute_name_index on movie_attribute (name);
-- при текущем заполнении таблиц индекс не помог, но если будет много других movie_attribute, он пригодится
-- как ускорить запрос в данном случае, не смог придумать



-- План при 10 000 000 строк после оптимизаций
-- +-------------------------------------------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                                                         |
-- +-------------------------------------------------------------------------------------------------------------------+
-- |Finalize Aggregate  (cost=110744.24..110744.25 rows=1 width=8)                                                     |
-- |  ->  Gather  (cost=110744.02..110744.23 rows=2 width=8)                                                           |
-- |        Workers Planned: 2                                                                                         |
-- |        ->  Partial Aggregate  (cost=109744.02..109744.03 rows=1 width=8)                                          |
-- |              ->  Hash Join  (cost=1.02..103494.02 rows=2500000 width=11)                                          |
-- |                    Hash Cond: (mav.attribute_id = ma.id)                                                          |
-- |                    ->  Parallel Seq Scan on movie_attribute_value mav  (cost=0.00..69118.00 rows=2500000 width=15)|
-- |                    ->  Hash  (cost=1.01..1.01 rows=1 width=4)                                                     |
-- |                          ->  Seq Scan on movie_attribute ma  (cost=0.00..1.01 rows=1 width=4)                     |
-- |                                Filter: ((name)::text = 'reviews'::text)                                           |
-- |JIT:                                                                                                               |
-- |  Functions: 15                                                                                                    |
-- |  Options: Inlining false, Optimization false, Expressions true, Deforming true                                    |
-- +-------------------------------------------------------------------------------------------------------------------+
