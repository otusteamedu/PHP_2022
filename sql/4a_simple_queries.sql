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

/*
Seq Scan on movie  (cost=0.00..203640.08 rows=8009527 width=32) (actual time=40.266..54452.670 rows=8006476 loops=1)
  Filter: (duration >= 120)
  Rows Removed by Filter: 1993524
Planning Time: 52.206 ms
JIT:
  Functions: 3
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 0.297 ms, Inlining 0.000 ms, Optimization 0.253 ms, Emission 2.778 ms, Total 3.328 ms"
Execution Time: 54746.185 ms
*/

-- Увеличение количества записей вызвало драматическое увеличение времени запроса

-- Создаем индекс для колонки duration
create index movie_duration_index on movie (duration);

/*
Index Only Scan using movie_duration_index on movie  (cost=0.43..167326.59 rows=8009266 width=32) (actual time=1.298..788.929 rows=8006476 loops=1)
  Index Cond: (duration >= 120)
  Heap Fetches: 0
Planning Time: 0.161 ms
JIT:
  Functions: 2
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 0.211 ms, Inlining 0.000 ms, Optimization 0.093 ms, Emission 1.076 ms, Total 1.381 ms"
Execution Time: 1075.530 ms
*/

-- Вывод: применение индекса уменьшило время запроса в 54 раза

/*==================================================================================================*/

-- Фильмы с названием из четырех букв
explain analyse
select name
from movie
where length(name) = 4;

/*
Seq Scan on movie  (cost=0.00..229.00 rows=50 width=29) (actual time=0.010..1.908 rows=299 loops=1)
  Filter: (length((name)::text) = 4)
  Rows Removed by Filter: 9701
Planning Time: 0.034 ms
Execution Time: 1.935 ms
*/

/*
Gather  (cost=1000.00..147136.00 rows=50000 width=29) (actual time=2.099..474.190 rows=344585 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on movie  (cost=0.00..141136.00 rows=20833 width=29) (actual time=3.272..422.400 rows=114862 loops=3)
        Filter: (length((name)::text) = 4)
        Rows Removed by Filter: 3218472
Planning Time: 0.214 ms
JIT:
  Functions: 6
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.461 ms, Inlining 0.000 ms, Optimization 0.714 ms, Emission 8.661 ms, Total 10.835 ms"
Execution Time: 487.463 ms
*/

-- Увеличение количества записей вызвало увеличение времени запроса

-- Создаем индекс для колонки name
create index movie_name_index on movie (name);

/*
Gather  (cost=1000.00..147136.00 rows=50000 width=29) (actual time=1.926..442.722 rows=344585 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on movie  (cost=0.00..141136.00 rows=20833 width=29) (actual time=2.104..404.478 rows=114862 loops=3)
        Filter: (length((name)::text) = 4)
        Rows Removed by Filter: 3218472
Planning Time: 0.048 ms
JIT:
  Functions: 6
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 0.865 ms, Inlining 0.000 ms, Optimization 0.498 ms, Emission 5.470 ms, Total 6.833 ms"
Execution Time: 456.786 ms
*/

-- Видим, что индекс не используется, и планировщик обходит все записи

-- Пробуем из исследовательских целей создать полнотекстовый индекс
create index search_index on movie using gin (to_tsvector('english', name));

/*
Gather  (cost=1000.00..147136.00 rows=50000 width=16) (actual time=2.596..462.696 rows=344585 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on movie  (cost=0.00..141136.00 rows=20833 width=16) (actual time=2.894..422.809 rows=114862 loops=3)
        Filter: (length((name)::text) = 4)
        Rows Removed by Filter: 3218472
Planning Time: 0.119 ms
JIT:
  Functions: 12
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.232 ms, Inlining 0.000 ms, Optimization 0.673 ms, Emission 7.608 ms, Total 9.513 ms"
Execution Time: 475.944 ms
*/

-- Вывод: если нужен запрос, где в условии используется функция, то, вероятно, лучше высчитывать значения предварительно
-- и сохранять в отдельную колонку, на которую уже создавать индекс
-- Эти два индекса в данном случае подлежат удалению

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

/*
Gather  (cost=1000.00..226331.18 rows=50002 width=33) (actual time=2.125..912.224 rows=333389 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on ticket  (cost=0.00..220330.98 rows=20834 width=33) (actual time=2.715..870.819 rows=111130 loops=3)
        Filter: (((created)::date <= (now())::date) AND ((created)::date >= ((now() - '1 day'::interval))::date))
        Rows Removed by Filter: 3222204
Planning Time: 0.178 ms
JIT:
  Functions: 6
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.157 ms, Inlining 0.000 ms, Optimization 0.589 ms, Emission 7.139 ms, Total 8.885 ms"
Execution Time: 925.169 ms
*/

-- Увеличение количества записей вызвало увеличение времени запроса

-- Создаем индекс для колонки created
create index on ticket (date(created));

/*
Bitmap Heap Scan on ticket  (cost=684.95..78658.61 rows=50000 width=33) (actual time=25.654..1557.176 rows=333389 loops=1)
  Recheck Cond: (((created)::date <= (now())::date) AND ((created)::date >= ((now() - '1 day'::interval))::date))
  Rows Removed by Index Recheck: 3759481
  Heap Blocks: exact=50251 lossy=33110
  ->  Bitmap Index Scan on ticket_date_idx  (cost=0.00..672.45 rows=50000 width=0) (actual time=18.436..18.436 rows=333389 loops=1)
        Index Cond: (((created)::date <= (now())::date) AND ((created)::date >= ((now() - '1 day'::interval))::date))
Planning Time: 0.065 ms
Execution Time: 1568.953 ms
*/

-- Индекс оказался неэффективен, подлежит удалению