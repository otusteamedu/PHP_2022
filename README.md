#Список фильмов за определенный день (простой запрос)
~~~~sql
explain analyse SELECT film.name as "Название", film.description as "Описание", film.duration as "Длительность (мин)", film.price as "Базовая стоимость билета (руб)"
FROM film
WHERE film.date_premier = now()::date;
~~~~
- Выполнение запроса без индексов при 10 тыс записей  
Execution Time: 3.759 ms

- Выполнение запроса без индексов при 1 млн записей  
Execution Time: 397.658 ms

Добавлен индекс
~~~~sql
create index film_date_premier_index on film using btree (date_premier);
~~~~

- Выполнение запроса c индексом при 10 тыс записей  
Execution Time: 0.074 ms

- Выполнение запроса c индексом при 1 млн записей  
Execution Time: 5.207 ms

ВЫВОД: Добавление индекса film_date_premier_index дало очень ощутимый прирост быстродействия, что при 10 тыс записей, что при 1 млн
С индексом запрос быстрее в 50-70 раз

#Список сеансов с повышенным коэффициентом цены (больше 1) за 2 недели (простой запрос)
~~~~sql
explain analyse SELECT start_timestamp::text, end_timestamp::text
FROM session
WHERE start_timestamp >= '2022-06-01 00:00:00' AND start_timestamp <= '2022-06-14 23:59:00' AND price_ratio > 1;
~~~~

- Выполнение запроса без индексов при 10 тыс записей  
Execution Time: 2.241 ms

- Выполнение запроса без индексов при 1 млн записей  
Execution Time: 127.306 ms


Добавлен индекс
~~~~sql
create index session_start_price_ratio_index on session using btree (start_timestamp, price_ratio);
~~~~

- Выполнение запроса c индексом при 10 тыс записей  
Execution Time: 0.313 ms

- Выполнение запроса c индексом при 1 млн записей  
Execution Time: 29.053 ms

ВЫВОД: Добавление индекса session_start_price_ratio_index дало прирост быстродействия, что при 10 тыс записей, что при 1 млн
С индексом запрос быстрее в 4-7 раз

#Список отмененных заказов (простой запрос)
~~~~sql
explain analyse SELECT * FROM orders WHERE status = 'canceled';
~~~~

- Выполнение запроса без индексов при 10 тыс записей  
Execution Time: 2.087 ms

- Выполнение запроса без индексов при 1 млн записей  
Execution Time: 160.815 ms

Добавлен индекс
~~~~sql
create index orders_status_index on orders using btree (status);
~~~~

- Выполнение запроса c индексом при 10 тыс записей:  
Execution Time: 0.740 ms

- Выполнение запроса c индексом при 1 млн записей  
Execution Time: 65.849 ms

ВЫВОД: Добавление индекса orders_status_index дало прирост быстродействия, что при 10 тыс записей, что при 1 млн
С индексом запрос быстрее в 2.5-3 раза

#Вывод списка актеров для каждого фильма (сложный запрос)
~~~~sql
explain analyse SELECT film.name as "Название",
string_agg(film_worker.name || ' ' ||  film_worker.surname, ', ')  as "Актерский состав"
FROM film
INNER JOIN film_composition ON film.id=film_composition.film_id
INNER JOIN film_worker ON film_composition.film_worker_id=film_worker.id
WHERE film.date_premier = '2022-06-09' AND film_composition.type = 'actor'
GROUP BY film.name;
~~~~

- Выполнение запроса без индексов при 10 тыс записей  
-- Execution Time: 6.154 ms

- Выполнение запроса без индексов при 1 млн записей  
 Execution Time: 490.435 ms

Добавлен индекс
~~~~sql
create index film_date_premier_index on film using btree (date_premier);
~~~~

- Выполнение запроса c индексом при 10 тыс записей  
Execution Time: 2.691 ms

- Выполнение запроса c индексом при 1 млн записей  
Execution Time: 183.635 ms


Добавлен еще один индекс
~~~~sql
create index film_composition_type_film_index on film_composition using btree (type, film_id);
~~~~

- Выполнение запроса c индексом при 10 тыс записей  
Execution Time: 0.504 ms

- Выполнение запроса c индексом при 1 млн записей  
Execution Time: 60.080 ms

ВЫВОД: Добавление индекса film_date_premier_index дало прирост быстродействия, что при 10 тыс запсией, что при 1 млн
С индексом запрос быстрее в 2-3 раза.
После добавления еще одного индекса film_composition_type_film_index запрос стал по итогу быстрее в 5-8 раз

#Нахождение самого прибыльного фильма (сложный запрос)
~~~~sql
explain analyse SELECT session.film_id, film.name, SUM(tickets.price) AS total
FROM tickets
INNER JOIN session ON tickets.session_id=session.id
INNER JOIN film ON session.film_id=film.id
WHERE tickets.active = true
GROUP BY session.film_id, film.name
ORDER BY total DESC
LIMIT 1;
~~~~

- Выполнение запроса без индексов при 10 тыс записей  
Execution Time: 31.792 ms

- Выполнение запроса без индексов при 1 млн записей  
Execution Time: 2901.932 ms


ВЫВОД: Подобрать индекс, который бы использовался в запросе не удалось, несмотря на различные попытки, в том числе:
~~~~sql
create index tickets_active_index on tickets using btree (active);
create index tickets_active_session_index on tickets using btree (active, session_id);
create index tickets_active_session_price_index on tickets using btree (active, session_id, price);
~~~~

# Подсчет на какую сумму приобретено билетов каждым из способов приобретения (сайт, касса, терминал) среди всех не VIP залов (сложный запрос)
~~~~sql
explain analyse SELECT purchase_method.name, SUM(tickets.price) as sum
FROM orders
INNER JOIN purchase_method ON orders.purchase_method_id=purchase_method.id
INNER JOIN tickets ON orders.id=tickets.order_id
INNER JOIN place ON tickets.place_id=place.id
INNER JOIN hall ON place.hall_id=hall.id
WHERE orders.status = 'paid' AND hall.vip = false
GROUP BY purchase_method.name
ORDER BY sum DESC;
~~~~

- Выполнение запроса без индексов при 10 тыс записей  
Execution Time: 9.130 ms

- Выполнение запроса без индексов при 1 млн записей  
Execution Time: 839.423 ms


Добавлен индекс
~~~~sql
create index orders_status_index on orders using btree (status);
~~~~

- Выполнение запроса c индексом при 10 тыс записей  
Execution Time: 7.586 ms

- Выполнение запроса c индексом при 1 млн записей  
Execution Time: 788.954 ms

ВЫВОД: Добавление индекса orders_status_index дало почти не ощутимый прирост быстродействия, что при 10 тыс запсией, что при 1 млн
С индексом запрос быстрее всего в 1.2 раза.
Подобрать подходящий еще индекс для данного запроса не удалось

#ВЫВОДЫ
1. На простых запросах индекс дает прирост в разы, а иногда и в десятки раз лучший результат
2. Значимой разницы в быстродействии работы запроса с индексом между количеством данных в 10 тыс строк и 1 млн строк не удалось выявить. Значит, даже при таком не большом количестве строк как 10 тыс полезно использовать индекс
3. Не ко всем сложным запросам удалось подобрать индекс (или вообще не решаемая задача, или не хватает опыта), кроме того один запрос стал лишь немного быстрее