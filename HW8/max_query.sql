SELECT film.name, sum(price_history.price) as price
FROM film,
     tickets,
     cinema_sessions,
     price_history
WHERE film.id = cinema_sessions.film_uuid
  AND cinema_sessions.id = tickets.cinema_sessions_uuid
  AND tickets.price_id = price_history.id
GROUP BY film.name
ORDER BY price DESC LIMIT 1;



SELECT film.name, sum(price_history.price) as price
    LEFT JOIN cinema_sessions on film.id = cinema_sessions.film_uuid
    LEFT JOIN tickets on tickets.cinema_sessions_uuid = cinema_sessions.id
    LEFT JOIN price_history on tickets.price_id = price_history.id
GROUP BY film.name
ORDER BY price DESC LIMIT 1;