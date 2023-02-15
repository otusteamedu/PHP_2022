--  Sch."Date" date    = INIT_DATE - 2; -- INIT_DATE +20 -345 FOR 10M   +3 -7 FOR 10_000
--  Sch."Time" time    = '18:00:00'; -- '12:00:00' '14:00:00' '16:00:00' '18:00:00' '20:00:00' '22:00:00'
EXPLAIN ANALYSE
SELECT MIN("Price"), MAX("Price")
FROM "Schedule" Sch
         INNER JOIN "Ticket" T on T."Schedule" = Sch.id
WHERE Sch."Date" = CURRENT_DATE - 2
  AND Sch."Time" = '18:00:00';