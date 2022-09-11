CREATE OR REPLACE VIEW view_actual_tasks AS
SELECT m.name       "Фильм",
       a.name       "Задача",
       v.date::text "Дата выполнения"
FROM movie as m
         INNER JOIN value v ON m.id = v.movie_id
         INNER JOIN attribute a ON a.id = v.attribute_id
         INNER JOIN attribute_type t ON t.id = a.type_id
WHERE v.date = current_date
   OR v.date = current_date + INTERVAL '20 day'
    AND a.id in (8, 9)
ORDER BY v.date, m.id;
