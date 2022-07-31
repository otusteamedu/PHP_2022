SELECT film.name, sum(ticket.price) as total_profit
FROM film,
     ticket,
     film_session
WHERE ticket.film_session_id = film_session.session_id
  AND film_session.film_id = film.film_id
  AND ticket.is_used = 1
GROUP BY film.name
ORDER BY total_profit DESC LIMIT 1