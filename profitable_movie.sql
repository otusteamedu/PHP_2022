SELECT m.name,
       sum(price) total_cost
FROM Movies m
         JOIN Displays d
              ON m.id = d.movie_id
         JOIN Tickets t
              on d.id = t.display_id
GROUP BY m.id, m.name
ORDER BY total_cost DESC
LIMIT 1