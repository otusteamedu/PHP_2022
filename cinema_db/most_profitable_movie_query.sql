SELECT m.title, movie_max_sum.total_price
FROM (
  SELECT movie_id, SUM (price) as total_price
  FROM seance s
  GROUP BY movie_id) movie_max_sum
JOIN movie m
ON m.id = movie_max_sum.movie_id
 ORDER BY total_price DESC
 LIMIT 1;