EXPLAIN ANALYSE
SELECT C."Name", H."Name", M."Name", Sch."Time"
FROM "Schedule" Sch
         INNER JOIN "Hall" H on H.id = Sch."Hall"
         INNER JOIN "Cinema" C on C.id = H."Cinema"
         INNER JOIN "Movie" M on M.id = Sch."Movie"
WHERE Sch."Date" = CURRENT_DATE;