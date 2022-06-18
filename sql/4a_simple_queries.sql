-- Фильмы, длящиеся больше двух часов
explain analyse
select 'name'
from movie
where duration >= 120;

/*
Seq Scan on movie  (cost=0.00..204.00 rows=8068 width=32) (actual time=0.010..1.925 rows=8036 loops=1)
  Filter: (duration >= 120)
  Rows Removed by Filter: 1964
Planning Time: 0.049 ms
Execution Time: 2.292 ms
*/

/*==================================================================================================*/

-- Фильмы с названием из четырех букв
explain analyse
select *
from movie
where length(name) = 4;

/*
Seq Scan on movie  (cost=0.00..229.00 rows=50 width=29) (actual time=0.010..1.908 rows=299 loops=1)
  Filter: (length((name)::text) = 4)
  Rows Removed by Filter: 9701
Planning Time: 0.034 ms
Execution Time: 1.935 ms
*/

/*==================================================================================================*/

-- Билеты, купленные за последние сутки
explain analyse
select *
from ticket
where (created::date <= now()::date)
  and (created::date >= (now() - interval '1 day')::date);

/*
Seq Scan on ticket  (cost=0.00..8.50 rows=1 width=34) (actual time=0.058..0.085 rows=4 loops=1)
  Filter: (((created)::date <= (now())::date) AND ((created)::date >= ((now() - '1 day'::interval))::date))
  Rows Removed by Filter: 197
Planning Time: 0.056 ms
Execution Time: 0.096 ms
*/