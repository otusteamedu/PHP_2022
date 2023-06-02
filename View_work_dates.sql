CREATE VIEW work_dates AS 
WITH work_dates_today AS
  (SELECT films.id,
          films.title,
          array_agg(CONCAT (attributes.name, ' - ', attribute_values.value_date)) AS works
   FROM films
   LEFT JOIN attribute_values ON attribute_values.film_id = films.id
   LEFT JOIN attributes ON attributes.id = attribute_values.attribute_id
   LEFT JOIN attribute_types ON attribute_types.id = attributes.type_id
   WHERE attribute_types.id = 4
     AND attribute_values.value_date = CURRENT_DATE
   GROUP BY films.id),
work_dates_after20days AS
  (SELECT films.id,
          films.title,
          array_agg(CONCAT (attributes.name, ' - ', attribute_values.value_date)) AS works
   FROM films
   LEFT JOIN attribute_values ON attribute_values.film_id = films.id
   LEFT JOIN attributes ON attributes.id = attribute_values.attribute_id
   LEFT JOIN attribute_types ON attribute_types.id = attributes.type_id
   WHERE attribute_types.id = 4
     AND attribute_values.value_date = CURRENT_DATE + 20
   GROUP BY films.id)
SELECT coalesce(work_dates_today.title, work_dates_after20days.title) as title,
       work_dates_today.works AS today,
       work_dates_after20days.works AS after_20
FROM work_dates_today
FULL JOIN work_dates_after20days ON work_dates_today.id = work_dates_after20days.id;

SELECT *
FROM work_dates;