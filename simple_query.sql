--------------------------- 1 запрос ----------------------------------------------------------
explain analyse select film_name from film where premier_date = NOW();
/*
Без индекса по дате премьеры 10 000 строк
Seq Scan on film  (cost=0.00..293.00 rows=1 width=46) (actual time=4.103..4.104 rows=0 loops=1)
  Filter: (premier_date = now())
  Rows Removed by Filter: 10000
Planning Time: 5.569 ms
Execution Time: 4.151 ms
*/

/* С индексом по дате премьеры 10 000 строк
Index Scan using film_premier_date_idx on film  (cost=0.29..8.30 rows=1 width=46) (actual time=1.113..1.114 rows=0 loops=1)
  Index Cond: (premier_date = now())
Planning Time: 5.260 ms
Execution Time: 1.158 ms
*/

/*
Анализ этого запроса показал, что применение индекса
 - немного ухудшило стоимость получения первой строки, но значительно улучшило стоимость получения всех строк
 - значительно снизилось время получения первой и всех строк
 Вывод: применение индекса по дате премьеры оправданно и полезно
*/

--------------------------- 2 запрос ----------------------------------------------------------
explain analyse select film_name from film where film_name LIKE '%2%';

/*
Без индекса по названию фильма 10 000 строк
Seq Scan on film  (cost=0.00..268.00 rows=2008 width=46) (actual time=0.018..5.183 rows=1947 loops=1)
  Filter: ((film_name)::text ~~ '%2%'::text)
  Rows Removed by Filter: 8053
Planning Time: 0.161 ms
Execution Time: 5.420 ms
*/

/*
С индексом по названию фильма 10 000 строк
Seq Scan on film  (cost=0.00..268.00 rows=2008 width=46) (actual time=0.027..6.410 rows=1947 loops=1)
  Filter: ((film_name)::text ~~ '%2%'::text)
  Rows Removed by Filter: 8053
Planning Time: 10.339 ms
Execution Time: 6.688 ms
*/

/*
Несмотря на наличие индекса по названию фильма он не использовался, время планирования и выполнения значительно ухудшилось.
Я так понимаю, что логичнее было бы использовать полнотекстовый индекс
*/

--------------------------- 3 запрос ----------------------------------------------------------

explain analyse select purchase_date from ticket where purchase_date < NOW();

/*
без индекса по дате покупки билета 10 000 записей
Seq Scan on ticket  (cost=0.00..223.30 rows=10586 width=4) (actual time=0.033..8.115 rows=9457 loops=1)
  Filter: (purchase_date < now())
  Rows Removed by Filter: 543
Planning Time: 0.225 ms
Execution Time: 9.925 ms

с индексом по дате покупки билета 10 000 записей
Seq Scan on ticket  (cost=0.00..205.00 rows=9444 width=4) (actual time=0.026..7.224 rows=9457 loops=1)
  Filter: (purchase_date < now())
  Rows Removed by Filter: 543
Planning Time: 0.276 ms
Execution Time: 8.952 ms

При количестве строк в 10000 индекс не применился
*/

----------------------------

/*
без индекса по дате покупки билета 1 000 000 записей

Seq Scan on ticket  (cost=0.00..20406.00 rows=943497 width=4) (actual time=0.046..406.682 rows=946086 loops=1)
  Filter: (purchase_date < now())
  Rows Removed by Filter: 53914
Planning Time: 116.234 ms
Execution Time: 500.643 ms

с индексом по дате покупки билета 1 000 000 записей
Index Only Scan using purchase_date_idx on ticket  (cost=0.43..19755.66 rows=943499 width=4) (actual time=4.543..1096.108 rows=946086 loops=1)
  Index Cond: (purchase_date < now())
  Heap Fetches: 0
Planning Time: 6.651 ms
Execution Time: 1265.402 ms

В данном случае индекс не эффективен, время выполнения увеличилось более чем в два раза
*/
