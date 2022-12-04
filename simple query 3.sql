-- Get count of all int values
SELECT count(*) FROM "values" WHERE "v_int" IS NOT NULL;

/*

При 10000 фильмах:
Aggregate  (cost=1376.36..1376.37 rows=1 width=8)
  ->  Seq Scan on "values"  (cost=0.00..1326.00 rows=20144 width=0)
        Filter: (v_int IS NOT NULL)
 */
