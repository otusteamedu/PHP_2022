/* 10 000 000 rows */

SET random_page_cost = 1.1;

/* first simple explain */
EXPLAIN ANALYZE
SELECT m.id
FROM movie AS m
WHERE length(m.name) = 2;
/*
Gather  (cost=1000.00..30754.00 rows=12500 width=4) (actual time=0.264..278.395 rows=250005 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on movie m  (cost=0.00..28504.00 rows=5208 width=4) (actual time=0.019..147.002 rows=83335 loops=3)
        Filter: (length((name)::text) = 2)
        Rows Removed by Filter: 749998
Planning Time: 1.593 ms
Execution Time: 292.384 ms
 */

/***** OPTIMIZE *****/
CREATE INDEX i_m_name_length ON movie using btree (length(name));
DROP INDEX i_m_name_length;
/*
Bitmap Heap Scan on movie m  (cost=141.31..13583.00 rows=12500 width=4) (actual time=80.173..164.901 rows=250005 loops=1)
  Recheck Cond: (length((name)::text) = 2)
  Heap Blocks: exact=12878
  ->  Bitmap Index Scan on i_m_name_length  (cost=0.00..138.18 rows=12500 width=0) (actual time=78.216..78.217 rows=250005 loops=1)
        Index Cond: (length((name)::text) = 2)
Planning Time: 3.390 ms
Execution Time: 178.571 ms
 */



/* second simple explain */
EXPLAIN ANALYZE
SELECT mav.id
FROM movie_attribute_value AS mav
WHERE mav.value_int = 400;
/*
Gather  (cost=1000.00..28474.83 rows=310 width=4) (actual time=16.572..1859.988 rows=278 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on movie_attribute_value mav  (cost=0.00..27443.83 rows=129 width=4) (actual time=51.627..1669.556 rows=93 loops=3)
        Filter: (value_int = 400)
        Rows Removed by Filter: 833241
Planning Time: 0.920 ms
Execution Time: 1860.094 ms
*/

/***** OPTIMIZE *****/
CREATE INDEX i_mav_value_int ON movie_attribute_value using btree (value_int);
DROP INDEX i_mav_value_int;
/*
Bitmap Heap Scan on movie_attribute_value mav  (cost=6.81..1094.24 rows=307 width=4) (actual time=1.744..186.514 rows=278 loops=1)
  Recheck Cond: (value_int = 400)
  Heap Blocks: exact=277
  ->  Bitmap Index Scan on i_mav_value_int  (cost=0.00..6.73 rows=307 width=0) (actual time=1.350..1.350 rows=278 loops=1)
        Index Cond: (value_int = 400)
Planning Time: 4.038 ms
Execution Time: 186.694 ms
 */



/* third simple explain */
EXPLAIN ANALYZE
SELECT mav.id
FROM movie_attribute_value AS mav
WHERE mav.value_float < 100;
/*
Gather  (cost=1000.00..31511.83 rows=30680 width=4) (actual time=0.915..1852.791 rows=30555 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on movie_attribute_value mav  (cost=0.00..27443.83 rows=12783 width=4) (actual time=0.799..1718.549 rows=10185 loops=3)
        Filter: (value_float < '100'::double precision)
        Rows Removed by Filter: 823148
Planning Time: 1.540 ms
Execution Time: 1856.382 ms
*/

/***** OPTIMIZE *****/
CREATE INDEX i_mav_value_float ON movie_attribute_value using btree (value_float);
DROP INDEX i_mav_value_float;
/*
Bitmap Heap Scan on movie_attribute_value mav  (cost=578.20..15384.70 rows=30680 width=4) (actual time=32.746..1541.297 rows=30555 loops=1)
  Recheck Cond: (value_float < '100'::double precision)
  Heap Blocks: exact=12715
  ->  Bitmap Index Scan on i_mav_value_float  (cost=0.00..570.53 rows=30680 width=0) (actual time=30.344..30.345 rows=30555 loops=1)
        Index Cond: (value_float < '100'::double precision)
Planning Time: 3.340 ms
Execution Time: 1543.832 ms
 */



/* first difficult explain */
EXPLAIN ANALYZE
SELECT COUNT(*)
FROM movie_attribute_value
         JOIN movie m ON m.id = movie_attribute_value.movie_id
WHERE movie_id >= 600
  AND movie_id <= 700;
/*
Finalize Aggregate  (cost=31248.47..31248.48 rows=1 width=8) (actual time=1827.089..1831.607 rows=1 loops=1)
  ->  Gather  (cost=31248.25..31248.46 rows=2 width=8) (actual time=1826.945..1831.585 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=30248.25..30248.26 rows=1 width=8) (actual time=1701.632..1701.634 rows=1 loops=3)
              ->  Nested Loop  (cost=0.43..30248.14 rows=45 width=0) (actual time=57.839..1701.571 rows=34 loops=3)
                    ->  Parallel Seq Scan on movie_attribute_value  (cost=0.00..30048.00 rows=45 width=4) (actual time=57.045..1700.071 rows=34 loops=3)
                          Filter: ((movie_id >= 600) AND (movie_id <= 700))
                          Rows Removed by Filter: 833299
                    ->  Index Only Scan using movie_pkey on movie m  (cost=0.43..4.45 rows=1 width=4) (actual time=0.036..0.036 rows=1 loops=102)
                          Index Cond: (id = movie_attribute_value.movie_id)
                          Heap Fetches: 0
Planning Time: 1.166 ms
Execution Time: 1831.677 ms
 */

/***** OPTIMIZE *****/
CREATE INDEX i_mav_movie_id ON movie_attribute_value using btree (movie_id);
DROP INDEX i_mav_movie_id;
/*
Aggregate  (cost=478.25..478.26 rows=1 width=8) (actual time=0.541..0.542 rows=1 loops=1)
  ->  Nested Loop  (cost=0.86..477.99 rows=106 width=0) (actual time=0.302..0.526 rows=102 loops=1)
        ->  Index Only Scan using i_mav_movie_id on movie_attribute_value  (cost=0.43..6.55 rows=106 width=4) (actual time=0.286..0.302 rows=102 loops=1)
              Index Cond: ((movie_id >= 600) AND (movie_id <= 700))
              Heap Fetches: 0
        ->  Index Only Scan using movie_pkey on movie m  (cost=0.43..4.45 rows=1 width=4) (actual time=0.002..0.002 rows=1 loops=102)
              Index Cond: (id = movie_attribute_value.movie_id)
              Heap Fetches: 0
Planning Time: 7.543 ms
Execution Time: 0.586 ms
 */



/* second difficult explain */
EXPLAIN ANALYZE
SELECT COUNT(*)
FROM movie_attribute_type AS mat
         JOIN movie_attribute ma ON mat.id = ma.movie_attribute_type_id
WHERE length(ma.name) = 5;
/*
Gather  (cost=1000.43..45467.88 rows=12500 width=4) (actual time=2.213..3351.040 rows=251120 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Nested Loop  (cost=0.43..43217.88 rows=5208 width=4) (actual time=2.704..3148.070 rows=83707 loops=3)
        ->  Parallel Seq Scan on movie_attribute ma  (cost=0.00..29988.00 rows=5208 width=8) (actual time=0.675..1780.564 rows=83707 loops=3)
              Filter: (length((name)::text) = 5)
              Rows Removed by Filter: 749627
        ->  Index Only Scan using movie_attribute_type_pkey on movie_attribute_type mat  (cost=0.43..2.54 rows=1 width=4) (actual time=0.016..0.016 rows=1 loops=251120)
              Index Cond: (id = ma.movie_attribute_type_id)
              Heap Fetches: 0
Planning Time: 3.724 ms
Execution Time: 3368.588 ms
 */



/* third difficult explain */
EXPLAIN ANALYZE
SELECT COUNT(*)
FROM movie_attribute_value as mav
         JOIN movie_attribute ma ON ma.id = mav.movie_attribute_id
WHERE value_int = 255;
/*
Finalize Aggregate  (cost=29003.64..29003.65 rows=1 width=8) (actual time=1907.333..1911.827 rows=1 loops=1)
  ->  Gather  (cost=29003.43..29003.64 rows=2 width=8) (actual time=1907.217..1911.817 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=28003.43..28003.44 rows=1 width=8) (actual time=1788.482..1788.483 rows=1 loops=3)
              ->  Nested Loop  (cost=0.43..28003.11 rows=128 width=0) (actual time=13.845..1788.331 rows=110 loops=3)
                    ->  Parallel Seq Scan on movie_attribute_value mav  (cost=0.00..27443.83 rows=128 width=4) (actual time=12.436..1744.743 rows=110 loops=3)
                          Filter: (value_int = 255)
                          Rows Removed by Filter: 833223
                    ->  Index Only Scan using movie_attribute_pkey on movie_attribute ma  (cost=0.43..4.37 rows=1 width=4) (actual time=0.389..0.389 rows=1 loops=330)
                          Index Cond: (id = mav.movie_attribute_id)
                          Heap Fetches: 0
Planning Time: 6.000 ms
Execution Time: 1911.887 ms
 */

/***** OPTIMIZE *****/
CREATE INDEX i_mav_value_int ON movie_attribute_value using btree (value_int);
DROP INDEX i_mav_value_int;
/*
Aggregate  (cost=2436.39..2436.40 rows=1 width=8) (actual time=257.051..257.053 rows=1 loops=1)
  ->  Nested Loop  (cost=7.24..2435.62 rows=307 width=0) (actual time=1.327..256.853 rows=330 loops=1)
        ->  Bitmap Heap Scan on movie_attribute_value mav  (cost=6.81..1094.24 rows=307 width=4) (actual time=1.302..251.464 rows=330 loops=1)
              Recheck Cond: (value_int = 255)
              Heap Blocks: exact=328
              ->  Bitmap Index Scan on i_mav_value_int  (cost=0.00..6.73 rows=307 width=0) (actual time=0.944..0.944 rows=330 loops=1)
                    Index Cond: (value_int = 255)
        ->  Index Only Scan using movie_attribute_pkey on movie_attribute ma  (cost=0.43..4.37 rows=1 width=4) (actual time=0.012..0.012 rows=1 loops=330)
              Index Cond: (id = mav.movie_attribute_id)
              Heap Fetches: 0
Planning Time: 3.380 ms
Execution Time: 257.100 ms
 */




SELECT *
FROM pg_indexes
WHERE tablename NOT LIKE 'pg%';