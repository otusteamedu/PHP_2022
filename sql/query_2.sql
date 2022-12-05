-- Запрос
analyse hall;
explain select name from hall where number_of_seats > 300;

-- План при 10 000 строк
-- +-------------------------------------------------------+
-- |QUERY PLAN                                             |
-- +-------------------------------------------------------+
-- |Seq Scan on hall  (cost=0.00..38.00 rows=1388 width=11)|
-- |  Filter: (number_of_seats > 300)                      |
-- +-------------------------------------------------------+



-- План при 10 000 000 строк
-- +-------------------------------------------------------------+
-- |QUERY PLAN                                                   |
-- +-------------------------------------------------------------+
-- |Seq Scan on hall  (cost=0.00..37739.00 rows=1394597 width=11)|
-- |  Filter: (number_of_seats > 300)                            |
-- +-------------------------------------------------------------+

-- Оптимизации



-- План при 10 000 000 строк после оптимизаций
