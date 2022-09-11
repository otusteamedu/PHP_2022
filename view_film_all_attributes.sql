CREATE OR REPLACE VIEW view_movies_attributes AS
SELECT m.name  "Фильм",
       t.name  "Тип атрибута",
       a.name  "Атрибут",
       CASE
           WHEN v.text IS NOT NULL THEN v.text
           WHEN v.int IS NOT NULL THEN v.int::text
           WHEN v.date IS NOT NULL THEN v.date::text
           WHEN v.bool IS NOT NULL THEN v.bool::text
           END "Значение"
FROM movie as m
         INNER JOIN value v on m.id = v.movie_id
         INNER JOIN attribute a on a.id = v.attribute_id
         INNER JOIN attribute_type t on t.id = a.type_id
ORDER BY m.id;
