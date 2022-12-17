CREATE VIEW marketing AS
SELECT m.name                                                 AS movie,
       mat.name                                               AS type_name,
       ma.name                                                AS attribute_name,
       CONCAT(mav.value_text, mav.value_bool, mav.value_date) AS value
FROM movie_attribute_value mav
         JOIN movie m ON m.id = mav.movie_id
         JOIN movie_attribute ma ON mav.movie_attribute_id = ma.id
         JOIN movie_attribute_type mat ON ma.movie_attribute_type_id = mat.id
ORDER BY movie, mat.id;



CREATE VIEW service AS
SELECT m.name  AS movie,
       ma.name AS now,
       null    AS after_20_days
FROM movie_attribute_value mav
         JOIN movie m ON m.id = mav.movie_id
         JOIN movie_attribute ma ON mav.movie_attribute_id = ma.id
         JOIN movie_attribute_type mat ON ma.movie_attribute_type_id = mat.id
WHERE mat.name = 'Служебные даты'
  AND mav.value_date = CURRENT_DATE
UNION
SELECT m.name  AS movie,
       null    AS now,
       ma.name AS after_20_days
FROM movie_attribute_value mav
         JOIN movie m ON m.id = mav.movie_id
         JOIN movie_attribute ma ON mav.movie_attribute_id = ma.id
         JOIN movie_attribute_type mat ON ma.movie_attribute_type_id = mat.id
WHERE mat.name = 'Служебные даты'
  AND mav.value_date = CURRENT_DATE + INTERVAL '20 days'
ORDER BY movie;