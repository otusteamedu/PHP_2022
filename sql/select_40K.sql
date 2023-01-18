/* 10 000 rows */

SET random_page_cost = 1.1;

/* first simple explain */
EXPLAIN ANALYZE
SELECT m.id
FROM movie AS m
WHERE length(m.name) = 2;
/*
Seq Scan on movie m  (cost=0.00..202.00 rows=50 width=4) (actual time=0.014..1.960 rows=1033 loops=1)
  Filter: (length((name)::text) = 2)
  Rows Removed by Filter: 8967
Planning Time: 2.548 ms
Execution Time: 2.036 ms
 */

/***** OPTIMIZE *****/
CREATE INDEX i_m_name_length ON movie using btree (length(name));
DROP INDEX i_m_name_length;
/*
Bitmap Heap Scan on movie m  (cost=4.67..58.94 rows=50 width=4) (actual time=1.174..1.482 rows=1033 loops=1)
  Recheck Cond: (length((name)::text) = 2)
  Heap Blocks: exact=52
  ->  Bitmap Index Scan on i_m_name_length  (cost=0.00..4.66 rows=50 width=0) (actual time=1.142..1.142 rows=1033 loops=1)
        Index Cond: (length((name)::text) = 2)
Planning Time: 4.146 ms
Execution Time: 1.560 ms
 */



/* second simple explain */
EXPLAIN ANALYZE
SELECT mav.id
FROM movie_attribute_value AS mav
WHERE mav.value_int = 400;
/*
Seq Scan on movie_attribute_value mav  (cost=0.00..183.00 rows=1 width=4) (actual time=0.721..1.571 rows=2 loops=1)
 Filter: (value_int = 400)
 Rows Removed by Filter: 9998
Planning Time: 1.573 ms
Execution Time: 1.592 ms
*/

/***** OPTIMIZE *****/
CREATE INDEX i_mav_value_int ON movie_attribute_value using btree (value_int);
DROP INDEX i_mav_value_int;
/*
Index Scan using i_mav_value_int on movie_attribute_value mav  (cost=0.29..8.30 rows=1 width=4) (actual time=0.545..0.548 rows=2 loops=1)
  Index Cond: (value_int = 400)
Planning Time: 3.352 ms
Execution Time: 0.570 ms
 */



/* third simple explain */
EXPLAIN ANALYZE
SELECT mav.id
FROM movie_attribute_value AS mav
WHERE mav.value_float < 100;
/*
Seq Scan on movie_attribute_value mav  (cost=0.00..183.00 rows=130 width=4) (actual time=0.047..1.511 rows=133 loops=1)
 Filter: (value_float < '100'::double precision)
 Rows Removed by Filter: 9867
Planning Time: 1.280 ms
Execution Time: 1.534 ms
*/

/***** OPTIMIZE *****/
CREATE INDEX i_mav_value_float ON movie_attribute_value using btree (value_float);
DROP INDEX i_mav_value_float;
/*
Bitmap Heap Scan on movie_attribute_value mav  (cost=5.29..64.92 rows=130 width=4) (actual time=0.599..0.693 rows=133 loops=1)
  Recheck Cond: (value_float < '100'::double precision)
  Heap Blocks: exact=55
  ->  Bitmap Index Scan on i_mav_value_float  (cost=0.00..5.26 rows=130 width=0) (actual time=0.584..0.585 rows=133 loops=1)
        Index Cond: (value_float < '100'::double precision)
Planning Time: 3.194 ms
Execution Time: 0.724 ms
 */



/* first difficult explain */
EXPLAIN ANALYZE
SELECT COUNT(*)
FROM movie_attribute_value
         JOIN movie m ON m.id = movie_attribute_value.movie_id
WHERE movie_id >= 600
  AND movie_id <= 700;
/*
Aggregate  (cost=362.16..362.17 rows=1 width=8) (actual time=1.596..1.597 rows=1 loops=1)
  ->  Nested Loop  (cost=0.29..361.88 rows=112 width=0) (actual time=0.025..1.580 rows=113 loops=1)
        ->  Seq Scan on movie_attribute_value  (cost=0.00..208.00 rows=112 width=4) (actual time=0.016..1.345 rows=113 loops=1)
              Filter: ((movie_id >= 600) AND (movie_id <= 700))
              Rows Removed by Filter: 9887
        ->  Index Only Scan using movie_pkey on movie m  (cost=0.29..1.37 rows=1 width=4) (actual time=0.002..0.002 rows=1 loops=113)
              Index Cond: (id = movie_attribute_value.movie_id)
              Heap Fetches: 0
Planning Time: 1.655 ms
Execution Time: 1.635 ms
 */

/***** OPTIMIZE *****/
CREATE INDEX i_mav_movie_id ON movie_attribute_value using btree (movie_id);
DROP INDEX i_mav_movie_id;
/*
Aggregate  (cost=160.69..160.70 rows=1 width=8) (actual time=0.548..0.549 rows=1 loops=1)
  ->  Nested Loop  (cost=0.57..160.41 rows=112 width=0) (actual time=0.342..0.534 rows=113 loops=1)
        ->  Index Only Scan using i_mav_movie_id on movie_attribute_value  (cost=0.29..6.53 rows=112 width=4) (actual time=0.329..0.344 rows=113 loops=1)
              Index Cond: ((movie_id >= 600) AND (movie_id <= 700))
              Heap Fetches: 0
        ->  Index Only Scan using movie_pkey on movie m  (cost=0.29..1.37 rows=1 width=4) (actual time=0.001..0.001 rows=1 loops=113)
              Index Cond: (id = movie_attribute_value.movie_id)
              Heap Fetches: 0
Planning Time: 6.337 ms
Execution Time: 0.594 ms
 */



/* second difficult explain */
EXPLAIN ANALYZE
SELECT ma.id
FROM movie_attribute_type AS mat
         JOIN movie_attribute ma ON mat.id = ma.movie_attribute_type_id
WHERE length(ma.name) = 5;
/*
Nested Loop  (cost=0.29..335.13 rows=50 width=4) (actual time=0.021..3.484 rows=995 loops=1)
  ->  Seq Scan on movie_attribute ma  (cost=0.00..208.00 rows=50 width=8) (actual time=0.013..1.812 rows=995 loops=1)
        Filter: (length((name)::text) = 5)
        Rows Removed by Filter: 9005
  ->  Index Only Scan using movie_attribute_type_pkey on movie_attribute_type mat  (cost=0.29..2.54 rows=1 width=4) (actual time=0.001..0.001 rows=1 loops=995)
        Index Cond: (id = ma.movie_attribute_type_id)
        Heap Fetches: 0
Planning Time: 1.710 ms
Execution Time: 3.588 ms
 */

/***** OPTIMIZE *****/
CREATE INDEX i_ma_name_length ON movie_attribute using btree (length(name));
DROP INDEX i_ma_name_length;
/*
Nested Loop  (cost=4.96..190.98 rows=50 width=4) (actual time=0.533..2.661 rows=995 loops=1)
  ->  Bitmap Heap Scan on movie_attribute ma  (cost=4.67..63.86 rows=50 width=8) (actual time=0.519..0.828 rows=995 loops=1)
        Recheck Cond: (length((name)::text) = 5)
        Heap Blocks: exact=58
        ->  Bitmap Index Scan on i_ma_name_length  (cost=0.00..4.66 rows=50 width=0) (actual time=0.503..0.503 rows=995 loops=1)
              Index Cond: (length((name)::text) = 5)
  ->  Index Only Scan using movie_attribute_type_pkey on movie_attribute_type mat  (cost=0.29..2.54 rows=1 width=4) (actual time=0.001..0.001 rows=1 loops=995)
        Index Cond: (id = ma.movie_attribute_type_id)
        Heap Fetches: 0
Planning Time: 3.436 ms
Execution Time: 2.743 ms
 */



/* third difficult explain */
EXPLAIN ANALYZE
SELECT COUNT(*)
FROM movie_attribute_value as mav
         JOIN movie_attribute ma ON ma.id = mav.movie_attribute_id
WHERE value_int = 255;
/*
Aggregate  (cost=187.31..187.32 rows=1 width=8) (actual time=1.302..1.303 rows=1 loops=1)
  ->  Nested Loop  (cost=0.29..187.30 rows=1 width=0) (actual time=0.604..1.298 rows=1 loops=1)
        ->  Seq Scan on movie_attribute_value mav  (cost=0.00..183.00 rows=1 width=4) (actual time=0.591..1.284 rows=1 loops=1)
              Filter: (value_int = 255)
              Rows Removed by Filter: 9999
        ->  Index Only Scan using movie_attribute_pkey on movie_attribute ma  (cost=0.29..4.30 rows=1 width=4) (actual time=0.009..0.009 rows=1 loops=1)
              Index Cond: (id = mav.movie_attribute_id)
              Heap Fetches: 0
Planning Time: 2.834 ms
Execution Time: 1.342 ms
 */

/***** OPTIMIZE *****/
CREATE INDEX i_mav_value_int ON movie_attribute_value using btree (value_int);
DROP INDEX i_mav_value_int;
/*
Aggregate  (cost=12.61..12.62 rows=1 width=8) (actual time=1.134..1.135 rows=1 loops=1)
  ->  Nested Loop  (cost=0.57..12.61 rows=1 width=0) (actual time=1.126..1.128 rows=1 loops=1)
        ->  Index Scan using i_mav_value_int on movie_attribute_value mav  (cost=0.29..8.30 rows=1 width=4) (actual time=1.106..1.108 rows=1 loops=1)
              Index Cond: (value_int = 255)
        ->  Index Only Scan using movie_attribute_pkey on movie_attribute ma  (cost=0.29..4.30 rows=1 width=4) (actual time=0.012..0.012 rows=1 loops=1)
              Index Cond: (id = mav.movie_attribute_id)
              Heap Fetches: 0
Planning Time: 3.373 ms
Execution Time: 1.175 ms
 */




SELECT *
FROM pg_indexes
WHERE tablename NOT LIKE 'pg%';