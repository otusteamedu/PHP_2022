SELECT
    movies.name AS Movie,
    COUNT(sessions.id) AS Sessions,
    COUNT(t.id) AS Tickets,
    SUM(t.price) AS Revenue
FROM sessions
JOIN movies ON sessions.movie_id = movies.id
JOIN session_ticket AS st ON sessions.id = st.session_id
JOIN tickets AS t ON st.ticket_id = t.id
GROUP BY Movie
ORDER BY Revenue DESC