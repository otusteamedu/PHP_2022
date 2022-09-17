SELECT f.name, SUM(t.price) as total_sum
FROM ticket t
    JOIN schedule sch ON sch.id=t.schedule_id
    JOIN film f ON f.id=sch.film_id
GROUP BY f.name
ORDER BY total_sum DESC
LIMIT 1;
