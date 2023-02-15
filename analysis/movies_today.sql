EXPLAIN ANALYSE
SELECT M."Name"
FROM "Schedule" Sch
         INNER JOIN "Movie" M on M.id = Sch."Movie"
WHERE Sch."Date" = CURRENT_DATE
GROUP BY M."Name";