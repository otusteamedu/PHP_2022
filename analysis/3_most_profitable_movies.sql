EXPLAIN ANALYSE
SELECT M."Name", SUM(t_sum.sum)
FROM "Schedule" AS Sch
         INNER JOIN "Movie" M on M.id = Sch."Movie",
     (SELECT "Schedule", SUM("Price") as sum
      FROM "Ticket"
      GROUP BY "Schedule") as t_sum
WHERE Sch.id = t_sum."Schedule"
GROUP BY M."Name"
ORDER BY sum DESC
LIMIT 3;