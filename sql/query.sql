SELECT session.film_id, film.name, SUM(tickets.price) AS total
FROM tickets
         INNER JOIN session ON tickets.session_id=session.id
         INNER JOIN film ON session.film_id=film.id
WHERE tickets.active=true
GROUP BY session.film_id, film.name
ORDER BY total DESC
LIMIT 1;