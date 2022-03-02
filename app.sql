-- Список билетов со статусом(оплачен, забронирован, свободен) для сеанса и фильма
SELECT hp.number as place_number,
       hp.type   as place_type,
       (
           p.film +
           p.session +
           CASE
               WHEN hp.type = 'VIP' THEN p.vip_place
               WHEN hp.type = 'COMFORT' THEN p.comfort_place
               WHEN hp.type = 'BUSINESS' THEN p.business_place
           END
       ) as price,
       COALESCE(
           (SELECT status FROM orders o WHERE s.id=o.session_id AND o.place_id=hp.id),
           'FREE'
       ) as status
FROM hall_places hp
LEFT JOIN halls h on hp.hull_id = h.id
LEFT JOIN sessions s on h.id = s.hall_id
LEFT JOIN films f on s.film_id = f.id
LEFT JOIN prices p on s.price_id = p.id
WHERE s.id=8
AND f.id=3;

-- Покупка билета (без транзакции)
INSERT INTO orders (session_id, place_id, status, amount) VALUES (5, 7, 'PAID', (
    SELECT  (
        p.film +
        p.session +
        CASE
            WHEN hp.type = 'VIP' THEN p.vip_place
            WHEN hp.type = 'COMFORT' THEN p.comfort_place
            WHEN hp.type = 'BUSINESS' THEN p.business_place
        END
    ) as price
    FROM sessions s
    LEFT JOIN films f on s.film_id = f.id
    LEFT JOIN halls h on h.id = s.hall_id
    LEFT JOIN hall_places hp on h.id = s.hall_id
    LEFT JOIN prices p on s.price_id = p.id
    WHERE f.id=2
    AND s.id=5
    AND s.hall_id=hp.hull_id
    AND hp.id=7
));

-- Самый прибыльный фильм
SELECT f.name, r.total
FROM films f
RIGHT JOIN (
    SELECT s.film_id, SUM(o.amount) as total
    FROM orders as o
    LEFT JOIN sessions s ON s.id = o.session_id
    LEFT JOIN films f ON s.film_id = f.id
    WHERE o.status='PAID'
    AND s.date_end<now()
    GROUP BY s.film_id
    ORDER BY total DESC
    LIMIT 1
) as r ON f.id = r.film_id;
