-- самый прибыльный фильм --
SELECT SUM(p.amount) as "profit", f.title FROM ticket t
INNER JOIN price p ON p.price_id = t.price_id
INNER JOIN film f ON f.film_id = p.film_id
GROUP BY f.title
ORDER BY "profit" DESC
LIMIT 1;
