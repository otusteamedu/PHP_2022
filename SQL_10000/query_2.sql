-- ищем фильм по названию
explain
select id, name, duration
from movies
where name like 'yQesmb2LY';

-- Seq Scan on movies  (cost=0.00..383.00 rows=1 width=35)
--   Filter: ((name)::text ~~ 'yQesmb2LY'::text)


CREATE INDEX idx_name_partial ON movies(name(10));

-- Seq Scan on movies  (cost=0.00..383.00 rows=1 width=35)
--   Filter: ((name)::text ~~ 'yQesmb2LY'::text)

-- @todo: ничего не изменилось?!