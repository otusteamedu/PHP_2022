SELECT title, sum(p.price_value)
FROM movie m
         JOIN session s on m.movie_id = s.movie_id
         JOIN ticket t on s.session_id = t.session_id
         JOIN price p on t.price_id = p.price_id
GROUP BY m.movie_id
ORDER BY sum(p.price_value) DESC
LIMIT 1;