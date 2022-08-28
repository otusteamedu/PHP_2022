SELECT move.name, SUM(move.price) AS total_price
FROM ticket
         JOIN schedule ON
    ticket.schedule_id = schedule.id
         JOIN session ON
    schedule.session_id = session.id
         JOIN move ON
    session.move_id = move.id
GROUP BY move.name
ORDER BY total_price DESC LIMIT 1;