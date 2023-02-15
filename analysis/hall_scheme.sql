--  P."Hall"   integer = 10; -- IN 1..50 FOR 10M   IN 1..15 FOR 10_000
--  Sch."Date" date    = INIT_DATE; -- INIT_DATE +20 -345 FOR 10M   +3 -7 FOR 10_000
--  Sch."Time" time    = '20:00:00'; -- '12:00:00' '14:00:00' '16:00:00' '18:00:00' '20:00:00' '22:00:00'
EXPLAIN ANALYSE
SELECT P."Row", P."Number", Solded_tickets."Place"::bool AS is_taken
FROM "Place" P
         LEFT JOIN
     (SELECT "Place"
      FROM "Schedule" Sch
               INNER JOIN "Ticket" T on T."Schedule" = Sch.id
      WHERE Sch."Date" = CURRENT_DATE
        AND Sch."Time" = '20:00:00') AS Solded_tickets ON P.id = Solded_tickets."Place"
WHERE P."Hall" = 10;