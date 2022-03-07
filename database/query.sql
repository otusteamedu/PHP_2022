SELECT film.name, sum(price.price) as price
FROM film,
     ticket,
     film_session,
     price
WHERE ticket.film_session_id = film_session.id
  AND film_session.film_id = film.id
    AND ticket.price_id = price.id
GROUP BY film.name
ORDER BY price DESC LIMIT 1
