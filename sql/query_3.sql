-- Запрос
analyse movie_attribute_value;
explain select value_text from movie_attribute_value where movie_attribute_value is not null;

-- План при 10 000 строк
-- +-------------------------------------------------------------------------+
-- |QUERY PLAN                                                               |
-- +-------------------------------------------------------------------------+
-- |Seq Scan on movie_attribute_value  (cost=0.00..105.00 rows=5970 width=11)|
-- |  Filter: (movie_attribute_value.* IS NOT NULL)                          |
-- +-------------------------------------------------------------------------+

-- План при 10 000 000 строк
-- +-------------------------------------------------------------------------------+
-- |QUERY PLAN                                                                     |
-- +-------------------------------------------------------------------------------+
-- |Seq Scan on movie_attribute_value  (cost=0.00..104117.77 rows=5969977 width=11)|
-- |  Filter: (movie_attribute_value.* IS NOT NULL)                                |
-- |JIT:                                                                           |
-- |  Functions: 3                                                                 |
-- |  Options: Inlining false, Optimization false, Expressions true, Deforming true|
-- +-------------------------------------------------------------------------------+

-- Оптимизации



-- План при 10 000 000 строк после оптимизаций
