SELECT film.name, sum(ticket.price) as price
FROM film,
     ticket,
     film_session
WHERE ticket.film_session_id = film_session.id
  AND film_session.film_id = film.id
GROUP BY film.name
ORDER BY price desc LIMIT 1
