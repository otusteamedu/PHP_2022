SELECT name
FROM movies
WHERE id = (SELECT total.movieId
            FROM (
                     SELECT SUM(mt.cost) as totalCost, ms.movieId
                     FROM movie_tickets as mt
                              LEFT JOIN movie_sessions as ms on ms.id = mt.sessionId
                     GROUP BY movieId
                     ORDER BY totalCost DESC
                 ) as total
            LIMIT 1
            )