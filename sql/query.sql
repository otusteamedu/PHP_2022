-- Запрос фильма, на котором кинотеатр получил максимальную выручку

SELECT m.name as movie_name, sum(price) AS total FROM ticket
INNER JOIN session s on s.id = ticket.session_id
INNER JOIN movie m on s.movie_id = m.id
GROUP BY m.name
ORDER BY total DESC
LIMIT 1;
