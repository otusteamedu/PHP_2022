--  P."Hall"   integer = 3; -- IN 1..15
--  Sch."Date" date    = INIT_DATE; -- INIT_DATE +- 15 days
--  Sch."Time" time    = '16:00:00'; -- '12:00:00' '14:00:00' '16:00:00' '18:00:00'
EXPLAIN ANALYSE
SELECT P."Row", P."Number", Solded_tickets."Place"::bool AS is_taken
FROM "Place" P
         LEFT JOIN
     (SELECT "Place"
      FROM "Schedule" Sch
               INNER JOIN "Ticket" T on T."Schedule" = Sch.id
      WHERE Sch."Date" = CURRENT_DATE
        AND Sch."Time" = '16:00:00'
      ORDER BY "Place") AS Solded_tickets ON P.id = Solded_tickets."Place"
WHERE P."Hall" = 3;