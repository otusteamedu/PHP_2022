SELECT sh."Movie", SUM(t_sum.sum)
FROM "Schedule" AS sh,
     (SELECT "Schedule", SUM("Price")
      FROM "Ticket"
      GROUP BY "Schedule") as t_sum
WHERE sh.id = t_sum."Schedule"
GROUP BY sh."Movie"
ORDER BY sum DESC
LIMIT 1;