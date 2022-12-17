SELECT movie.title, SUM(t.price) sum
FROM movie
         JOIN session s
              on movie.id = s.movie_id
         JOIN ticket t on s.id = t.session_id
GROUP BY movie.title
ORDER BY sum DESC
LIMIT 1;