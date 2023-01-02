------------------ 10 000------------------
set random_page_cost = 1.1;

DROP INDEX IF EXISTS films_rating_idx;
EXPLAIN ANALYZE SELECT * FROM films WHERE rating > 0  and rating <= 50;
/*
Seq Scan on films  (cost=0.00..521.00 rows=5008 width=271) (actual time=0.018..2.345 rows=5008 loops=1)
  Filter: ((rating > 0) AND (rating <= 50))
  Rows Removed by Filter: 4992
Planning Time: 1.888 ms
Execution Time: 2.667 ms
*/

CREATE INDEX films_rating_idx ON films (rating);
EXPLAIN ANALYZE SELECT * FROM films WHERE rating > 0  and rating <= 50;
/*
Bitmap Heap Scan on films  (cost=58.22..504.34 rows=5008 width=271) (actual time=2.754..4.162 rows=5008 loops=1)
  Recheck Cond: ((rating > 0) AND (rating <= 50))
  Heap Blocks: exact=371
  ->  Bitmap Index Scan on films_rating_idx  (cost=0.00..56.96 rows=5008 width=0) (actual time=2.701..2.702 rows=5008 loops=1)
        Index Cond: ((rating > 0) AND (rating <= 50))
Planning Time: 4.023 ms
Execution Time: 4.602 ms
*/


DROP INDEX IF EXISTS films_release_date_idx;
EXPLAIN ANALYZE SELECT id, title, release_date FROM films WHERE
        release_date >= '1990-01-01' AND release_date <  '1999-12-31';
/*
Seq Scan on films  (cost=0.00..521.00 rows=2333 width=267) (actual time=0.009..3.448 rows=2334 loops=1)
  Filter: ((release_date >= '1990-01-01'::date) AND (release_date < '1999-12-31'::date))
  Rows Removed by Filter: 7666
Planning Time: 0.060 ms
Execution Time: 3.687 ms
*/
CREATE INDEX films_release_date_idx ON films (release_date);
EXPLAIN ANALYZE SELECT id, title, release_date FROM films WHERE
        release_date >= '1990-01-01' AND release_date <  '1999-12-31';
/*
Bitmap Heap Scan on films  (cost=31.91..437.92 rows=2334 width=267) (actual time=0.681..1.962 rows=2334 loops=1)
  Recheck Cond: ((release_date >= '1990-01-01'::date) AND (release_date < '1999-12-31'::date))
  Heap Blocks: exact=371
  ->  Bitmap Index Scan on films_release_date_idx  (cost=0.00..31.32 rows=2334 width=0) (actual time=0.603..0.603 rows=2334 loops=1)
        Index Cond: ((release_date >= '1990-01-01'::date) AND (release_date < '1999-12-31'::date))
Planning Time: 5.726 ms
Execution Time: 2.136 ms
*/

DROP INDEX IF EXISTS films_title_idx;
EXPLAIN ANALYZE SELECT id, title FROM films WHERE title = 'film-fge';
/*
Seq Scan on films  (cost=0.00..189.00 rows=21 width=13) (actual time=0.142..2.203 rows=15 loops=1)
  Filter: ((title)::text = 'film-fge'::text)
  Rows Removed by Filter: 9985
Planning Time: 3.851 ms
Execution Time: 2.231 ms
*/
CREATE INDEX films_title_idx ON films (title);
EXPLAIN ANALYZE SELECT id, title FROM films WHERE title = 'film-fge';
/*
Bitmap Heap Scan on films  (cost=1.55..21.68 rows=21 width=13) (actual time=1.719..1.746 rows=15 loops=1)
  Recheck Cond: ((title)::text = 'film-fge'::text)
  Heap Blocks: exact=14
  ->  Bitmap Index Scan on films_title_idx  (cost=0.00..1.54 rows=21 width=0) (actual time=1.702..1.703 rows=15 loops=1)
        Index Cond: ((title)::text = 'film-fge'::text)
Planning Time: 2.879 ms
Execution Time: 1.776 ms
*/

------------------ 1 000 000------------------
DROP INDEX IF EXISTS films_rating_idx;
EXPLAIN ANALYZE SELECT * FROM films WHERE rating > 0  and rating <= 50;
/*
Seq Scan on films  (cost=0.00..21370.00 rows=502267 width=21) (actual time=0.009..126.285 rows=500376 loops=1)
  Filter: ((rating > 0) AND (rating <= 50))
  Rows Removed by Filter: 499624
Planning Time: 2.990 ms
Execution Time: 148.296 ms
*/

CREATE INDEX films_rating_idx ON films (rating);
EXPLAIN ANALYZE SELECT * FROM films WHERE rating > 0  and rating <= 50;
/*
Index Scan using films_rating_idx on films  (cost=0.42..17524.81 rows=502267 width=21) (actual time=1.378..326.176 rows=500376 loops=1)
  Index Cond: ((rating > 0) AND (rating <= 50))
Planning Time: 5.261 ms
Execution Time: 360.490 ms
*/


DROP INDEX IF EXISTS films_release_date_idx;
EXPLAIN ANALYZE SELECT id, title, release_date FROM films WHERE
        release_date >= '1990-01-01' AND release_date < '1999-12-31';
/*
Seq Scan on films  (cost=0.00..21370.00 rows=228796 width=17) (actual time=0.010..131.767 rows=232509 loops=1)
  Filter: ((release_date >= '1990-01-01'::date) AND (release_date < '1999-12-31'::date))
  Rows Removed by Filter: 767491
Planning Time: 4.458 ms
Execution Time: 143.486 ms
*/
CREATE INDEX films_release_date_idx ON films (release_date);
EXPLAIN ANALYZE SELECT id, title, release_date FROM films WHERE
        release_date >= '1990-01-01' AND release_date < '1999-12-31';
/*
Index Scan using films_release_date_idx on films  (cost=0.42..11801.95 rows=228896 width=17) (actual time=0.020..236.207 rows=232509 loops=1)
  Index Cond: ((release_date >= '1990-01-01'::date) AND (release_date < '1999-12-31'::date))
Planning Time: 4.898 ms
Execution Time: 249.883 ms
*/

DROP INDEX IF EXISTS films_title_idx;
EXPLAIN ANALYZE SELECT id, title FROM films WHERE title = 'film-fge';
/*
Gather  (cost=1000.00..12792.83 rows=2145 width=13) (actual time=3.622..124.828 rows=2382 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on films  (cost=0.00..11578.33 rows=894 width=13) (actual time=0.042..55.783 rows=794 loops=3)
        Filter: ((title)::text = 'film-fge'::text)
        Rows Removed by Filter: 332539
Planning Time: 2.780 ms
Execution Time: 125.238 ms
*/

CREATE INDEX films_title_idx ON films (title);
EXPLAIN ANALYZE SELECT id, title FROM films WHERE title = 'film-fge';
/*
Bitmap Heap Scan on films  (cost=19.25..1967.09 rows=2145 width=13) (actual time=4.946..7.720 rows=2382 loops=1)
  Recheck Cond: ((title)::text = 'film-fge'::text)
  Heap Blocks: exact=2001
  ->  Bitmap Index Scan on films_title_idx  (cost=0.00..18.71 rows=2145 width=0) (actual time=4.681..4.681 rows=2382 loops=1)
        Index Cond: ((title)::text = 'film-fge'::text)
Planning Time: 4.163 ms
Execution Time: 7.864 ms
*/

------------------ 10 000 000------------------
DROP INDEX IF EXISTS films_rating_idx;
EXPLAIN ANALYZE SELECT * FROM films WHERE rating > 0  and rating <= 50;
/*
Seq Scan on films  (cost=0.00..222295.55 rows=5322634 width=21) (actual time=125.937..21955.686 rows=4999256 loops=1)
  Filter: ((rating > 0) AND (rating <= 50))
  Rows Removed by Filter: 5000744
Planning Time: 27.910 ms
JIT:
  Functions: 2
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 7.293 ms, Inlining 0.000 ms, Optimization 23.579 ms, Emission 89.142 ms, Total 120.014 ms"
Execution Time: 22471.134 ms
*/

CREATE INDEX films_rating_idx ON films (rating);
EXPLAIN ANALYZE SELECT * FROM films WHERE rating > 0  and rating <= 50;
/*
Index Scan using films_rating_idx on films  (cost=0.43..174408.03 rows=4985000 width=21) (actual time=1.591..47878.512 rows=4999256 loops=1)
  Index Cond: ((rating > 0) AND (rating <= 50))
Planning Time: 12.112 ms
JIT:
  Functions: 2
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 0.348 ms, Inlining 0.000 ms, Optimization 0.000 ms, Emission 0.000 ms, Total 0.348 ms"
Execution Time: 48341.145 ms
 */


DROP INDEX IF EXISTS films_release_date_idx;
EXPLAIN ANALYZE SELECT id, title, release_date FROM films WHERE
        release_date >= '1990-01-01' AND release_date < '1999-12-31';
/*
Seq Scan on films  (cost=0.00..213695.00 rows=2341180 width=17) (actual time=5.319..1388.613 rows=2332780 loops=1)
  Filter: ((release_date >= '1990-01-01'::date) AND (release_date < '1999-12-31'::date))
  Rows Removed by Filter: 7667220
Planning Time: 1.657 ms
JIT:
  Functions: 4
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 0.862 ms, Inlining 0.000 ms, Optimization 0.355 ms, Emission 4.705 ms, Total 5.922 ms"
Execution Time: 1505.277 ms

*/
CREATE INDEX films_release_date_idx ON films (release_date);
EXPLAIN ANALYZE SELECT id, title, release_date FROM films WHERE
        release_date >= '1990-01-01' AND release_date < '1999-12-31';
/*
Index Scan using films_release_date_idx on films  (cost=0.43..119181.01 rows=2342176 width=17) (actual time=7.004..9285.451 rows=2332780 loops=1)
  Index Cond: ((release_date >= '1990-01-01'::date) AND (release_date < '1999-12-31'::date))
Planning Time: 10.479 ms
JIT:
  Functions: 4
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.028 ms, Inlining 0.000 ms, Optimization 0.300 ms, Emission 6.443 ms, Total 7.771 ms"
Execution Time: 9464.262 ms

*/

DROP INDEX IF EXISTS films_title_idx;
EXPLAIN ANALYZE SELECT id, title FROM films WHERE title = 'film-fge';
/*
Gather  (cost=1000.00..118946.93 rows=21686 width=13) (actual time=3.971..540.738 rows=23167 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on films  (cost=0.00..115778.33 rows=9036 width=13) (actual time=5.401..457.973 rows=7722 loops=3)
        Filter: ((title)::text = 'film-fge'::text)
        Rows Removed by Filter: 3325611
Planning Time: 1.380 ms
JIT:
  Functions: 12
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 5.212 ms, Inlining 0.000 ms, Optimization 1.178 ms, Emission 12.919 ms, Total 19.308 ms"
Execution Time: 543.156 ms


*/
CREATE INDEX films_title_idx ON films (title);
EXPLAIN ANALYZE SELECT id, title FROM films WHERE title = 'film-fge';
/*
Bitmap Heap Scan on films  (cost=189.40..19846.07 rows=21686 width=13) (actual time=20.440..148.234 rows=23167 loops=1)
  Recheck Cond: ((title)::text = 'film-fge'::text)
  Heap Blocks: exact=19438
  ->  Bitmap Index Scan on films_title_idx  (cost=0.00..183.98 rows=21686 width=0) (actual time=13.324..13.325 rows=23167 loops=1)
        Index Cond: ((title)::text = 'film-fge'::text)
Planning Time: 5.513 ms
Execution Time: 150.511 ms

*/