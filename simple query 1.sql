-- Get all films.
SELECT "id", "name" FROM "films";

/*

При 10000 фильмах:
Seq Scan on films  (cost=0.00..178.00 rows=10000 width=30)

 */
