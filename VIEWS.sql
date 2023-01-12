CREATE OR REPLACE VIEW `movie_tasks` AS
SELECT movies.title AS "title",
       (SELECT attribute_movie.val_date FROM attribute_movie WHERE movie_id = movies.id AND DATE(attribute_movie.val_date) = CURDATE()) AS "today",
       (SELECT attribute_movie.val_date FROM attribute_movie WHERE movie_id = movies.id AND DATE(attribute_movie.val_date) = CURDATE() + 20) AS "at_20_days"
FROM movies
         JOIN attribute_movie ON movies.id = attribute_movie.movie_id
         JOIN attributes ON attribute_movie.attribute_id = attributes.id
         JOIN attribute_types ON attributes.attribute_type_id = attribute_types.id
WHERE DATE(attribute_movie.val_date) = CURDATE() OR DATE(attribute_movie.val_date) = CURDATE() + 20;

CREATE OR REPLACE VIEW `marketing` AS
SELECT movies.title AS "title",
       attribute_types.name AS "attr_type",
       attributes.name AS "attr_name",
       CASE
           WHEN attribute_types.field = "val_string" THEN attribute_movie.val_string
           WHEN attribute_types.field = "val_integer" THEN attribute_movie.val_integer
           WHEN attribute_types.field = "val_bool" THEN attribute_movie.val_bool
           WHEN attribute_types.field = "val_date" THEN attribute_movie.val_date
           WHEN attribute_types.field = "val_float" THEN attribute_movie.val_float
           END  AS "value"
FROM movies
         JOIN attribute_movie ON movies.id = attribute_movie.movie_id
         JOIN attributes ON attribute_movie.attribute_id = attributes.id
         JOIN attribute_types ON attributes.attribute_type_id = attribute_types.id;