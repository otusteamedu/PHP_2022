SELECT films.id,
       films.title,
       sum(tickets.cost) AS summa
FROM films
LEFT JOIN shows ON shows.film_id = films.id
LEFT JOIN tickets ON tickets.show_id = shows.id
GROUP BY films.id
ORDER BY summa DESC
LIMIT 1