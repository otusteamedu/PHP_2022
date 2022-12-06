SELECT film_id, sum(tickets.price) as total_sum FROM tickets
JOIN screening s on screening_id = s.id
WHERE sold = true
GROUP BY s.film_id
ORDER BY total_sum DESC
LIMIT 1;