# PHP_2022

# Простые запросы

### Количество сессий для каждого фильма за последнюю неделю

```sql
explain
SELECT movie_id, count(*)
FROM session
where start between now() - (interval '7 days') and now()
GROUP BY movie_id;
```

Время выполнения для 10 тысяч записей: **38 мс**

План запроса:
```sql
GroupAggregate  (cost=301.85..302.67 rows=44 width=12)
                Group Key: movie_id
  ->  Sort  (cost=301.85..301.98 rows=50 width=4)
        Sort Key: movie_id
        ->  Seq Scan on session  (cost=0.00..300.44 rows=50 width=4)
              Filter: ((start <= now()) AND (start >= (now() - '7 days'::interval)))
```

Время выполнения для 1 миллионе записей: **290 мс**

План запроса:
```sql
Finalize HashAggregate  (cost=19557.70..19751.11 rows=19341 width=12)
  Group Key: movie_id
  ->  Gather  (cost=17768.66..19476.38 rows=16264 width=12)
        Workers Planned: 2
        ->  Partial HashAggregate  (cost=16768.66..16849.98 rows=8132 width=12)
              Group Key: movie_id
              ->  Parallel Seq Scan on session  (cost=0.00..16728.00 rows=8132 width=4)
                    Filter: ((start <= now()) AND (start >= (now() - '7 days'::interval)))
```

Для ускорения выборки по полю start добавил индекс:
```sql
CREATE INDEX ix_session_start ON session (start);
```

Время выполнения для 1 миллионе записей с индексом: **55 мс**

План запроса:
```sql
HashAggregate  (cost=8307.67..8501.45 rows=19378 width=12)
  Group Key: movie_id
  ->  Bitmap Heap Scan on session  (cost=416.88..8209.89 rows=19556 width=4)
        Recheck Cond: ((start >= (now() - '7 days'::interval)) AND (start <= now()))
        ->  Bitmap Index Scan on ix_session_start  (cost=0.00..411.99 rows=19556 width=0)
              Index Cond: ((start >= (now() - '7 days'::interval)) AND (start <= now()))
```

Индекс сократил время выполнения запроса более чем в 5 раз

### Выбор покупателя с самыми большими тратами на билеты

```sql
SELECT sum(price), customer_id
FROM ticket
GROUP BY customer_id
ORDER BY sum(price) desc
LIMIT 1;
```

Время выполнения для 10 тысяч записей: **60 мс**

План запроса:
```sql
Limit  (cost=357.19..357.19 rows=1 width=12)
       ->  Sort  (cost=357.19..381.06 rows=9546 width=12)
        Sort Key: (sum(price)) DESC
        ->  HashAggregate  (cost=214.00..309.46 rows=9546 width=12)
              Group Key: customer_id
              ->  Seq Scan on ticket  (cost=0.00..164.00 rows=10000 width=8)
```

Время выполнения для 1 миллионе записей: **720 мс**

План запроса:
```sql
Limit  (cost=87823.06..87823.06 rows=1 width=12)
       ->  Sort  (cost=87823.06..89054.82 rows=492704 width=12)
        Sort Key: (sum(price)) DESC
        ->  HashAggregate  (cost=72620.00..85359.54 rows=492704 width=12)
              Group Key: customer_id
              Planned Partitions: 16
              ->  Seq Scan on ticket  (cost=0.00..16370.00 rows=1000000 width=8)
```

Для ускорения выборки добавил составной индекс по полям customer_id и price. price добавил для того, чтобы в индексе хранилась необходимая информация:
```sql
CREATE INDEX ix_ticket_customer_id_price ON ticket (customer_id, price);
```

Время выполнения для 1 миллионе записей с индексом: **255 мс**

План запроса:
```sql
Limit  (cost=38366.99..38366.99 rows=1 width=12)
  ->  Sort  (cost=38366.99..39598.75 rows=492704 width=12)
        Sort Key: (sum(price)) DESC
        ->  GroupAggregate  (cost=0.42..35903.46 rows=492704 width=12)
              Group Key: customer_id
              ->  Index Only Scan using ix_ticket_customer_id_price on ticket  (cost=0.42..25976.42 rows=1000000 width=8)
```

Индекс сократил время выполнения запроса почти в три раза

### Получение премьер на ближайшую неделю

```sql
SELECT *
FROM movie
WHERE premiere_date BETWEEN now() AND now() + (interval '7 day');
```

Время выполнения для 10 тысяч записей: **60 мс**

План запроса:
```sql
Seq Scan on movie  (cost=0.00..866.00 rows=197 width=475)
  Filter: ((premiere_date >= now()) AND (premiere_date <= (now() + '7 days'::interval)))
```

Время выполнения для 1 миллионе записей: **66 мс**

План запроса:
```sql
Gather  (cost=1000.00..76309.78 rows=18992 width=476)
  Workers Planned: 2
  ->  Parallel Seq Scan on movie  (cost=0.00..73410.58 rows=7913 width=476)
        Filter: ((premiere_date >= now()) AND (premiere_date <= (now() + '7 days'::interval)))
```

Запрос выполняется быстро. Оптимизация не требуется

# Сложные запросы

### Сумма продаж по каждому фильму за прошлую неделю

```sql
SELECT m.name, sum(t.price)
FROM ticket t
         INNER JOIN session s ON s.id = t.session_id
         INNER JOIN movie m ON s.movie_id = m.id
WHERE s.start BETWEEN now() - (interval '7 days') AND now()::date
GROUP BY m.name
ORDER BY sum(t.price) DESC;
```

Время выполнения для 10 тысяч записей: **53мс**

План запроса:
```sql
Sort  (cost=1320.91..1321.34 rows=174 width=46)
      Sort Key: (sum(t.price)) DESC
  ->  GroupAggregate  (cost=1311.39..1314.43 rows=174 width=46)
        Group Key: m.name
        ->  Sort  (cost=1311.39..1311.82 rows=174 width=42)
              Sort Key: m.name
              ->  Nested Loop  (cost=326.47..1304.91 rows=174 width=42)
                    ->  Hash Join  (cost=326.18..516.44 rows=174 width=8)
                          Hash Cond: (t.session_id = s.id)
                          ->  Seq Scan on ticket t  (cost=0.00..164.00 rows=10000 width=8)
                          ->  Hash  (cost=324.00..324.00 rows=174 width=8)
                                ->  Seq Scan on session s  (cost=0.00..324.00 rows=174 width=8)
                                      Filter: ((start >= (now() - '7 days'::interval)) AND (start <= (now())::date))
                    ->  Memoize  (cost=0.30..4.54 rows=1 width=42)
                          Cache Key: s.movie_id
                          ->  Index Scan using movie_pk on movie m  (cost=0.29..4.53 rows=1 width=42)
                                Index Cond: (id = s.movie_id)
```

Время выполнения для 1 миллионе записей: **420 мс**

План запроса:
```sql
Sort  (cost=68038.86..68083.22 rows=17745 width=46)
  Sort Key: (sum(t.price)) DESC
  ->  Finalize GroupAggregate  (cost=64698.81..66786.49 rows=17745 width=46)
        Group Key: m.name
        ->  Gather Merge  (cost=64698.81..66535.10 rows=14788 width=46)
              Workers Planned: 2
              ->  Partial GroupAggregate  (cost=63698.78..63828.18 rows=7394 width=46)
                    Group Key: m.name
                    ->  Sort  (cost=63698.78..63717.27 rows=7394 width=42)
                          Sort Key: m.name
                          ->  Nested Loop  (cost=17862.53..63223.64 rows=7394 width=42)
                                ->  Parallel Hash Join  (cost=17862.09..29492.51 rows=7394 width=8)
                                      Hash Cond: (t.session_id = s.id)
                                      ->  Parallel Seq Scan on ticket t  (cost=0.00..10536.67 rows=416667 width=8)
                                      ->  Parallel Hash  (cost=17769.67..17769.67 rows=7394 width=8)
                                            ->  Parallel Seq Scan on session s  (cost=0.00..17769.67 rows=7394 width=8)
                                                  Filter: ((start >= (now() - '7 days'::interval)) AND (start <= (now())::date))
                                ->  Memoize  (cost=0.43..4.58 rows=1 width=42)
                                      Cache Key: s.movie_id
                                      ->  Index Scan using movie_pk on movie m  (cost=0.42..4.57 rows=1 width=42)
                                            Index Cond: (id = s.movie_id)
```

Для ускорения выборки добавил индексы по FK:
```sql
CREATE INDEX ix_ticket_session_id ON ticket (session_id);
CREATE INDEX ix_session_movie_id ON session (movie_id);
```

Время выполнения для 1 миллионе записей с индексами: **300 мс**

Индекс сократил время выполнения запроса 40%

```sql
Sort  (cost=57985.29..58029.36 rows=17627 width=46)
  Sort Key: (sum(t.price)) DESC
  ->  Finalize GroupAggregate  (cost=54668.26..56742.10 rows=17627 width=46)
        Group Key: m.name
        ->  Gather Merge  (cost=54668.26..56492.38 rows=14690 width=46)
              Workers Planned: 2
              ->  Partial GroupAggregate  (cost=53668.23..53796.77 rows=7345 width=46)
                    Group Key: m.name
                    ->  Sort  (cost=53668.23..53686.59 rows=7345 width=42)
                          Sort Key: m.name
                          ->  Nested Loop  (cost=8005.97..53196.59 rows=7345 width=42)
                                ->  Parallel Hash Join  (cost=8005.54..19635.96 rows=7345 width=8)
                                      Hash Cond: (t.session_id = s.id)
                                      ->  Parallel Seq Scan on ticket t  (cost=0.00..10536.67 rows=416667 width=8)
                                      ->  Parallel Hash  (cost=7913.73..7913.73 rows=7345 width=8)
                                            ->  Parallel Bitmap Heap Scan on session s  (cost=377.11..7913.73 rows=7345 width=8)
                                                  Recheck Cond: ((start >= (now() - '7 days'::interval)) AND (start <= (now())::date))
                                                  ->  Bitmap Index Scan on ix_session_start  (cost=0.00..372.70 rows=17627 width=0)
                                                        Index Cond: ((start >= (now() - '7 days'::interval)) AND (start <= (now())::date))
                                ->  Memoize  (cost=0.43..4.59 rows=1 width=42)
                                      Cache Key: s.movie_id
                                      ->  Index Scan using movie_pk on movie m  (cost=0.42..4.58 rows=1 width=42)
                                            Index Cond: (id = s.movie_id)
```

Добавил в индекс информацию по цене:
```sql
CREATE INDEX ix_ticket_session_id_price ON ticket (session_id, price);
```

Время выполнения для 1 миллионе записей с доработанными индексами: **180 мс**

Индекс сократил время выполнения запроса в сравнении с прошлым индексом на 40%

План выполнения:
```sql
Sort  (cost=54320.36..54364.38 rows=17607 width=46)
  Sort Key: (sum(t.price)) DESC
  ->  Finalize GroupAggregate  (cost=51007.41..53078.73 rows=17607 width=46)
        Group Key: m.name
        ->  Gather Merge  (cost=51007.41..52829.30 rows=14672 width=46)
              Workers Planned: 2
              ->  Partial GroupAggregate  (cost=50007.38..50135.76 rows=7336 width=46)
                    Group Key: m.name
                    ->  Sort  (cost=50007.38..50025.72 rows=7336 width=42)
                          Sort Key: m.name
                          ->  Nested Loop  (cost=377.77..49536.38 rows=7336 width=42)
                                ->  Nested Loop  (cost=377.33..16007.77 rows=7336 width=8)
                                      ->  Parallel Bitmap Heap Scan on session s  (cost=376.91..7913.31 rows=7336 width=8)
                                            Recheck Cond: ((start >= (now() - '7 days'::interval)) AND (start <= (now())::date))
                                            ->  Bitmap Index Scan on ix_session_start  (cost=0.00..372.50 rows=17607 width=0)
                                                  Index Cond: ((start >= (now() - '7 days'::interval)) AND (start <= (now())::date))
                                      ->  Index Only Scan using ix_ticket_session_id_price on ticket t  (cost=0.42..1.08 rows=2 width=8)
                                            Index Cond: (session_id = s.id)
                                ->  Memoize  (cost=0.43..4.59 rows=1 width=42)
                                      Cache Key: s.movie_id
                                      ->  Index Scan using movie_pk on movie m  (cost=0.42..4.58 rows=1 width=42)
                                            Index Cond: (id = s.movie_id)
```

### 10 самых популярных фильмов по количеству проданных билетов и стоимость проданных билетов на эти фильмы

```sql
SELECT m.name, count(t.*), sum(t.price)
FROM movie m
         INNER JOIN session s ON m.id = s.movie_id
         INNER JOIN ticket t ON s.id = t.session_id
GROUP BY m.name
ORDER BY count(t.*) DESC
LIMIT 10;
```

Время выполнения для 10 тысяч записей: **43 мс**

План запроса:
```sql
Limit  (cost=1772.62..1772.64 rows=10 width=54)
       ->  Sort  (cost=1772.62..1797.62 rows=10000 width=54)
        Sort Key: (count(t.*)) DESC
        ->  HashAggregate  (cost=1456.52..1556.52 rows=10000 width=54)
              Group Key: m.name
              ->  Hash Join  (cost=1165.00..1381.52 rows=10000 width=86)
                    Hash Cond: (s.movie_id = m.id)
                    ->  Hash Join  (cost=299.00..489.26 rows=10000 width=52)
                          Hash Cond: (t.session_id = s.id)
                          ->  Seq Scan on ticket t  (cost=0.00..164.00 rows=10000 width=52)
                          ->  Hash  (cost=174.00..174.00 rows=10000 width=8)
                                ->  Seq Scan on session s  (cost=0.00..174.00 rows=10000 width=8)
                    ->  Hash  (cost=741.00..741.00 rows=10000 width=42)
                          ->  Seq Scan on movie m  (cost=0.00..741.00 rows=10000 width=42)
```

Время выполнения для 1 миллионе записей: **4000 мс**

План запроса:
```sql
Limit  (cost=331927.34..331927.36 rows=10 width=54)
  ->  Sort  (cost=331927.34..334426.69 rows=999742 width=54)
        Sort Key: (count(t.*)) DESC
        ->  Finalize GroupAggregate  (cost=189555.09..310323.27 rows=999742 width=54)
              Group Key: m.name
              ->  Gather Merge  (cost=189555.09..294075.85 rows=833334 width=54)
                    Workers Planned: 2
                    ->  Partial GroupAggregate  (cost=188555.06..196888.40 rows=416667 width=54)
                          Group Key: m.name
                          ->  Sort  (cost=188555.06..189596.73 rows=416667 width=86)
                                Sort Key: m.name
                                ->  Parallel Hash Join  (cost=95428.58..129722.75 rows=416667 width=86)
                                      Hash Cond: (s.movie_id = m.id)
                                      ->  Parallel Hash Join  (cost=18356.00..39754.42 rows=416667 width=52)
                                            Hash Cond: (t.session_id = s.id)
                                            ->  Parallel Seq Scan on ticket t  (cost=0.00..10536.67 rows=416667 width=52)
                                            ->  Parallel Hash  (cost=11519.67..11519.67 rows=416667 width=8)
                                                  ->  Parallel Seq Scan on session s  (cost=0.00..11519.67 rows=416667 width=8)
                                      ->  Parallel Hash  (cost=68203.59..68203.59 rows=416559 width=42)
                                            ->  Parallel Seq Scan on movie m  (cost=0.00..68203.59 rows=416559 width=42)
JIT:
  Functions: 27
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
```

Не удалось подобрать индексы, чтобы ускорить запрос

### Фильмы, которые показывают сегодня

```sql
SELECT DISTINCT m.name
FROM movie m
         INNER JOIN session s ON m.id = s.movie_id
WHERE start::date = now()::date;
```

Время выполнения для 10 тысяч записей: **35 мс**

План запроса:
```sql
Unique  (cost=598.54..598.79 rows=50 width=38)
        ->  Sort  (cost=598.54..598.66 rows=50 width=38)
        Sort Key: m.name
        ->  Nested Loop  (cost=0.29..597.13 rows=50 width=38)
              ->  Seq Scan on session s  (cost=0.00..274.00 rows=50 width=4)
                    Filter: ((start)::date = (now())::date)
              ->  Index Scan using movie_pk on movie m  (cost=0.29..6.46 rows=1 width=42)
                    Index Cond: (id = s.movie_id)
```

Время выполнения для 1 миллионе записей: **200 мс**

План запроса:
```sql
Unique  (cost=30104.26..30699.09 rows=5000 width=38)
  ->  Gather Merge  (cost=30104.26..30686.59 rows=5000 width=38)
        Workers Planned: 2
        ->  Sort  (cost=29104.23..29109.44 rows=2083 width=38)
              Sort Key: m.name
              ->  Nested Loop  (cost=0.42..28989.41 rows=2083 width=38)
                    ->  Parallel Seq Scan on session s  (cost=0.00..15686.33 rows=2083 width=4)
                          Filter: ((start)::date = (now())::date)
                    ->  Index Scan using movie_pk on movie m  (cost=0.42..6.39 rows=1 width=42)
                          Index Cond: (id = s.movie_id)
```

Не удалось подобрать индексы, чтобы ускорить запрос
