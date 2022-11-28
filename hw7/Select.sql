SELECT most_profitable, MAX(max_sum_price) FROM
                               (SELECT films.name as most_profitable, SUM(pricelist.price) as max_sum_price FROM tickets
                                LEFT JOIN pricelist ON tickets.id_price = pricelist.id
                                LEFT JOIN films ON tickets.id_film = films.id
                                GROUP BY tickets.id_films)