SELECT move_name, SUM(total_price) as total_price FROM ticket
GROUP BY move_name
ORDER BY total_price DESC
    LIMIT 1
;