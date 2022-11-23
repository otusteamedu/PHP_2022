-- Запрос фильма, на котором кинотеатр получил максимальную выручку

SELECT m.name as movie_name, sum(t.price) AS total FROM ticket t
INNER JOIN session s on s.id = t.session_id
INNER JOIN movie m on s.movie_id = m.id
GROUP BY m.name
ORDER BY total DESC
LIMIT 1;
