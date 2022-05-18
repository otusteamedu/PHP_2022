select
    sum(s.film_id * t.price)	as max_sale,
    f.name as film_name
FROM ticket as t
         INNER JOIN session as s on t.session_id=s.id
         INNER JOIN film as f on s.film_id=f.id
GROUP BY f.name
ORDER BY max_sale DESC
    LIMIT 1