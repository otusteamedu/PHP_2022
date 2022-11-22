    SELECT movies.id, movies.name, sum(tickets.price) s
    FROM tickets
    JOIN displays ON displays.id = tickets.display_id
    JOIN movies ON movies.id = displays.movie_id
    GROUP BY movies.id, movies.name
    ORDER BY s DESC
