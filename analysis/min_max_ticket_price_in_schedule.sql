--  Sch."Date"  date    = INIT_DATE; -- INIT_DATE +- 15 days
--  Sch."Time"  time    = '14:00:00'; -- '12:00:00' '14:00:00' '16:00:00' '18:00:00'
--  Sch."Movie" integer = IN 1..5
EXPLAIN ANALYSE
SELECT MIN("Price"), MAX("Price")
FROM "Schedule" Sch
         INNER JOIN "Ticket" T on T."Schedule" = Sch.id
WHERE Sch."Date" = CURRENT_DATE - 10
  AND Sch."Time" = '16:00:00'
  AND Sch."Movie" = 2;