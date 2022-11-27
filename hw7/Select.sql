SELECT MAX(max_sum_price) FROM
        (SELECT SUM(price) as max_sum_price FROM tickets
         LEFT JOIN pricelist ON tickets.id_film = pricelist.id_film GROUP BY id_films)