SELECT move.name, SUM(sales_history.session_price) as max_price
FROM sales_history
         JOIN move ON
    move.id = sales_history.move_id
         JOIN ticket ON
    ticket.id = sales_history.ticket_id
GROUP BY move.name
ORDER BY max_price DESC LIMIT 1
;