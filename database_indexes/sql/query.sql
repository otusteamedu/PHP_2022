-- simple query --

-- Самый прибыльный фильм
SELECT film.name, sum(ticket.price) as price FROM film, ticket, film_session
WHERE ticket.film_session_id = film_session.id
  AND film_session.film_id = film.id
GROUP BY film.name
ORDER BY price DESC LIMIT 1;

-- Список фильмов на завтра
SELECT film.name FROM film, film_session
WHERE film_session.film_id = film.id
  AND film_session.date = (now() + interval '1 day')::date
GROUP BY film.name;

-- Сумма проданных билетов на завтра на фильм с id = 1
SELECT sum(ticket.price) FROM ticket, film_session
WHERE film_session.date = (now() + interval '1 day')::date
  AND ticket.film_session_id = film_session.id
  AND film_session.film_id = 1;

-- hard query --

-- Получение списка проданных билетов за все время
SELECT film.name, film_session.date, film_session.start_time, film_session.end_time, hall.name, ticket.price, place.place_number
FROM film, film_session, hall, ticket, place
WHERE film_session.hall_id = hall.id
    AND ticket.film_session_id = film_session.id
    AND film_session.film_id = film.id
    AND place.id = ticket.place_id
ORDER BY film_session.date;

-- Получить список сеансов за все время
SELECT film.name as film, film_session.date, hall.id as hall FROM film_session
JOIN film on film_session.film_id = film.id
JOIN hall on hall.id = film_session.hall_id;

-- Получение мест в залах на все сеансы
SELECT film.name as film_name, film_session.date, hall.id as hall, row.name as row, place.place_number FROM film_session
JOIN film on film.id = film_session.film_id
JOIN hall on hall.id = film_session.hall_id
JOIN place on hall.id = place.hall_id
JOIN row on row.id = place.row_id;
