SELECT f.id, f.name, sum(t.price)
FROM films f
JOIN orders t on f.id = t.film_id
GROUP BY f.id, f.name
ORDER BY sum(t.price) DESC
LIMIT 1;