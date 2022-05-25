select
    sum(tt.price)	as max_sale,
    f.name as film_name
FROM ticket as t
         INNER JOIN ticket_type as tt on t.ticket_type_id=tt.id
         INNER JOIN session as s on t.session_id=s.id
         INNER JOIN film as f on s.film_id=f.id
GROUP BY f.name
ORDER BY max_sale DESC
    LIMIT 1