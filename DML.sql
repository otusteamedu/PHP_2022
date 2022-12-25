SELECT f.name, SUM(price) as sum FROM orders
    JOIN seance s on orders.seance_id = s.id
    JOIN films f on s.film_id = f.id
        GROUP BY f.id ORDER BY sum DESC;