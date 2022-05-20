select
    sum(t.price)	as max_sale,
    f.name as film_name
FROM customer_ticket as ct
         INNER JOIN ticket as t on ct.ticket_id=t.id
         INNER JOIN session as s on ct.session_id=s.id
         INNER JOIN film as f on s.film_id=f.id
GROUP BY f.name
ORDER BY max_sale DESC
    LIMIT 1