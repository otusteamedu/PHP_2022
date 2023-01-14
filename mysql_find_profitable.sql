select SUM(orders.final_price) as sum, films.title as title
from orders
         join films on orders.film_id = films.id
where orders.refund IS NULL
group by orders.film_id
order by sum desc
limit 1;