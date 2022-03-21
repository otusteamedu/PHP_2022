-- Get 20 tickets in current month
SELECT t.* FROM "tickets" t
WHERE EXTRACT(YEAR FROM t."Date") = EXTRACT(YEAR FROM now())
      and EXTRACT(MONTH FROM t."Date") = EXTRACT(MONTH FROM now())
ORDER BY t."Date" DESC LIMIT 20;

-- Get 10 films with Duration more 2 hours and less 2.5 hours
SELECT f.* FROM "films" f
WHERE f."Duration" >= 120 AND f."Duration" <= 180
ORDER BY f."Duration" LIMIT 10;

-- Get 20 rows from schedule in Monday
SELECT s.* FROM "schedule" s
WHERE s."Day" = 'monday'
LIMIT 10;

-- Get the most expensive in the IMAX ticket
SELECT f."Title", t."Row_ID" as "Row", t."Place", t."Date", t."Amount" FROM tickets t
LEFT JOIN "schedule" sh ON sh."ID" = t."Schedule_ID"
LEFT JOIN "halls" h ON h."ID" = sh."Hall_ID"
LEFT JOIN "films" f ON f."ID" = sh."Film_ID"
WHERE t."Amount" = (SELECT MAX ("Amount") FROM tickets)
AND extract(YEAR FROM t."Date") = extract(YEAR FROM now())
AND h."Title" LIKE 'Hall IMAX'
LIMIT 1;

-- Get the most profitable film
SELECT "films"."Title", sum("tickets"."Amount") as "Total_profit"
FROM "films", "tickets", "schedule"
WHERE "tickets"."Schedule_ID" = "schedule"."ID" AND "schedule"."Film_ID" = "films"."ID"
GROUP BY "films"."Title"
ORDER BY "Total_profit" DESC
LIMIT 1;

-- Get the longest film and the count of tickets sold for that film
SELECT f."Title", f."Duration", COUNT(s.*) FROM films f
LEFT JOIN schedule s on f."ID" = s."Film_ID"
LEFT JOIN tickets t on s."ID" = t."Schedule_ID"
WHERE f."Duration" = (SELECT MAX("Duration") FROM films)
GROUP BY f."Title", f."Duration"
LIMIT 1;
