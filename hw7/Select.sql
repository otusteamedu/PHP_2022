SELECT most_profitable, MAX(max_sum_price) FROM
    (SELECT films.name as most_profitable, SUM(pricelist.price) as max_sum_price FROM tickets
        LEFT JOIN sessions ON tickets.id_session = sessions.id
        LEFT JOIN films ON sessions.id_film = films.id
        LEFT JOIN pricelist ON tickets.id_price = pricelist.id
        GROUP BY sessions.id_film)