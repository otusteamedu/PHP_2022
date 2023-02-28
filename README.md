# PHP_2022

### Простой запрос 1

~~~sql
select * from film where date_from > '2022-07-20' and date_to<'2022-07-20';

create index dates_film on film using btree (date_from, date_to);
~~~
Выполнение без индекса 10_000: 1.571 ms

Выполнение с индексом 10_000: 0.060 ms

Выполнение без индекса 1_000_000: 49.123 ms

Выполнение с индексом 1_000_000: 0.157 ms

### Простой запрос 2

~~~sql
SELECT * from session where id_hall=1 and price between 900 and 1000;

create index session_id_hall_price on session using btree (id_hall,price);
~~~

Выполнение без индекса 10_000: 2.141 ms

Выполнение с индексом 10_000: 0.438 ms

Выполнение без индекса 1_000_000: 95.238 ms

Выполнение с индексом 1_000_000: 28.457 ms

### Простой запрос 3

~~~sql
select * from ticket where id_film=100;

create index ticket_id_film on ticket using btree (id_film);
~~~

Выполнение без индекса 10_000: 1.850 ms

Выполнение с индексом 10_000: 0.114 ms

Выполнение без индекса 1_000_000: 62.368 ms

Выполнение с индексом 1_000_000: 1.207 ms


### Сложный запрос 1

~~~sql
SELECT * FROM film
JOIN ticket t on film.id = t.id_film
JOIN hall h on t.id_hall = h.id
where t.id_film=1000;

create index ticket_id_film on ticket using btree (id_film);
~~~

Выполнение без индекса 10_000: 1.031

Выполнение с индексом 10_000: 0.195

Выполнение без индекса 1_000_000: 73.052

Выполнение с индексом 1_000_000: 3.178


### Сложный запрос 2

~~~sql
select SUM(ticket.ticket_price)
from ticket
         join film f on ticket.id_film = f.id
where f.rating>5
group by f.rating
having SUM(ticket.ticket_price)>10000
order by f.rating

create index film_rating on film using btree (id,rating);
create index ticket_price_id_film on ticket using btree (id_film,ticket_price);
~~~
Выполнение без индекса 10_000: 24.641

Выполнение с индексом 10_000: 16.618

Выполнение без индекса 1_000_000: 648.295

Выполнение с индексом 1_000_000: 337.560



### Сложный запрос 3

~~~sql
select ticket.id_hall from ticket
join hall h on ticket.id_hall = h.id
join seat s on ticket.id_seat = s.id
join film f on ticket.id_film = f.id
where id_seat>10 and id_film>1000
group by ticket.id_hall, ticket.id_film

create index ticket_index on ticket using btree (id_hall,id_film,id_seat);
~~~
Выполнение без индекса 10_000: 22.379

Выполнение с индексом 10_000: 18.090

Выполнение без индекса 1_000_000: 414.803

Выполнение с индексом 1_000_000: 276.919