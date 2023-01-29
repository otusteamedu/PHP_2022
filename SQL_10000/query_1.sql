-- Короткие фильмы
explain
select id, name, duration
from movies
where duration between 90 and 100
and is_deleted = false;

-- Seq Scan on movies  (cost=0.00..409.00 rows=1082 width=35)
--   Filter: ((NOT is_deleted) AND (duration >= 90) AND (duration <= 100))


CREATE INDEX idx_duration ON movies(duration);

-- Bitmap Heap Scan on movies  (cost=20.62..297.71 rows=1082 width=35)
--   Recheck Cond: ((duration >= 90) AND (duration <= 100))
--   Filter: (NOT is_deleted)
--   ->  Bitmap Index Scan on idx_duration  (cost=0.00..20.35 rows=1206 width=0)
--         Index Cond: ((duration >= 90) AND (duration <= 100))


