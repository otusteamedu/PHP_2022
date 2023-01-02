------------------ 10 000------------------

DROP INDEX IF EXISTS films_rating_idx;
EXPLAIN ANALYZE SELECT avg(rating) FROM films WHERE rating > 0  and rating <= 50;
/*
 Aggregate  (cost=249.92..249.93 rows=1 width=32) (actual time=3.174..3.175 rows=1 loops=1)
  ->  Seq Scan on films  (cost=0.00..223.36 rows=10624 width=4) (actual time=0.017..2.181 rows=10000 loops=1)
        Filter: ((rating > 0) AND (rating <= 50))
Planning Time: 2.720 ms
Execution Time: 3.201 ms
 */

CREATE INDEX films_rating_idx ON films (rating);
EXPLAIN ANALYZE SELECT avg(rating) FROM films WHERE rating > 0  and rating <= 50;
/*
 Aggregate  (cost=239.00..239.01 rows=1 width=32) (actual time=3.439..3.441 rows=1 loops=1)
  ->  Seq Scan on films  (cost=0.00..214.00 rows=10000 width=4) (actual time=0.022..2.285 rows=10000 loops=1)
        Filter: ((rating > 0) AND (rating <= 50))
Planning Time: 6.512 ms
Execution Time: 3.580 ms
 */

DROP INDEX IF EXISTS film_attribute_types_inx;
EXPLAIN ANALYSE SELECT f.id, f.title, fav.value as value FROM films as f
    JOIN film_attribute_values fav on f.id = fav.film_id
    JOIN film_attributes fa on fav.attribute_id = fa.id
    JOIN film_attribute_types fat on fat.id = fa.film_type_id
        WHERE fat.type = 'text';
/*
 Nested Loop  (cost=347.46..557.82 rows=50 width=23) (actual time=3.699..9.592 rows=1235 loops=1)
  ->  Hash Join  (cost=347.18..542.18 rows=50 width=14) (actual time=3.680..6.703 rows=1235 loops=1)
        Hash Cond: (fav.attribute_id = fa.id)
        ->  Seq Scan on film_attribute_values fav  (cost=0.00..157.00 rows=10000 width=18) (actual time=0.011..1.004 rows=10000 loops=1)
        ->  Hash  (cost=346.55..346.55 rows=50 width=4) (actual time=3.656..3.658 rows=1197 loops=1)
              Buckets: 2048 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 59kB
              ->  Hash Join  (cost=15.03..346.55 rows=50 width=4) (actual time=0.022..3.273 rows=1197 loops=1)
                    Hash Cond: (fa.film_type_id = fat.id)
                    ->  Seq Scan on film_attributes fa  (cost=0.00..305.00 rows=10000 width=8) (actual time=0.003..1.336 rows=10000 loops=1)
                    ->  Hash  (cost=15.00..15.00 rows=2 width=4) (actual time=0.013..0.014 rows=1 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Seq Scan on film_attribute_types fat  (cost=0.00..15.00 rows=2 width=4) (actual time=0.010..0.011 rows=1 loops=1)
                                Filter: ((type)::text = 'text'::text)
                                Rows Removed by Filter: 4
  ->  Index Scan using pk_film_id on films f  (cost=0.29..0.31 rows=1 width=13) (actual time=0.002..0.002 rows=1 loops=1235)
        Index Cond: (id = fav.film_id)
Planning Time: 12.218 ms
Execution Time: 9.700 ms
 */

CREATE INDEX film_attribute_types_inx ON film_attribute_types (type);
EXPLAIN ANALYSE SELECT f.id, f.title, fav.value as value FROM films as f
    JOIN film_attribute_values fav on f.id = fav.film_id
    JOIN film_attributes fa on fav.attribute_id = fa.id
    JOIN film_attribute_types fat on fat.id = fa.film_type_id
        WHERE fat.type = 'text';
/*
 Hash Join  (cost=619.08..853.08 rows=2000 width=23) (actual time=7.044..9.980 rows=1235 loops=1)
  Hash Cond: (f.id = fav.film_id)
  ->  Seq Scan on films f  (cost=0.00..164.00 rows=10000 width=13) (actual time=0.012..1.007 rows=10000 loops=1)
  ->  Hash  (cost=594.08..594.08 rows=2000 width=14) (actual time=7.018..7.023 rows=1235 loops=1)
        Buckets: 2048  Batches: 1  Memory Usage: 74kB
        ->  Hash Join  (cost=379.57..594.08 rows=2000 width=14) (actual time=3.278..6.577 rows=1235 loops=1)
              Hash Cond: (fav.attribute_id = fa.id)
              ->  Seq Scan on film_attribute_values fav  (cost=0.00..157.00 rows=10000 width=18) (actual time=0.005..1.080 rows=10000 loops=1)
              ->  Hash  (cost=354.57..354.57 rows=2000 width=4) (actual time=3.264..3.267 rows=1197 loops=1)
                    Buckets: 2048  Batches: 1  Memory Usage: 59kB
                    ->  Hash Join  (cost=1.07..354.57 rows=2000 width=4) (actual time=0.019..3.003 rows=1197 loops=1)
                          Hash Cond: (fa.film_type_id = fat.id)
                          ->  Seq Scan on film_attributes fa  (cost=0.00..305.00 rows=10000 width=8) (actual time=0.003..1.222 rows=10000 loops=1)
                          ->  Hash  (cost=1.06..1.06 rows=1 width=4) (actual time=0.010..0.012 rows=1 loops=1)
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                ->  Seq Scan on film_attribute_types fat  (cost=0.00..1.06 rows=1 width=4) (actual time=0.007..0.008 rows=1 loops=1)
                                      Filter: ((type)::text = 'text'::text)
                                      Rows Removed by Filter: 4
Planning Time: 4.694 ms
Execution Time: 10.107 ms
 */

DROP INDEX IF EXISTS film_attribute_values_inx;
EXPLAIN ANALYSE SELECT f.id, f.title, fav.value as value FROM films as f
    JOIN film_attribute_values fav on f.id = fav.film_id
        WHERE fav.value = 'value-fge';
/*
 Nested Loop  (cost=1.72..26.50 rows=7 width=23) (actual time=0.031..0.070 rows=7 loops=1)
  ->  Bitmap Heap Scan on film_attribute_values fav  (cost=1.44..8.98 rows=7 width=14) (actual time=0.020..0.032 rows=7 loops=1)
        Recheck Cond: (value = 'value-fge'::text)
        Heap Blocks: exact=6
        ->  Bitmap Index Scan on film_attribute_values_idx  (cost=0.00..1.44 rows=7 width=0) (actual time=0.015..0.015 rows=7 loops=1)
              Index Cond: (value = 'value-fge'::text)
  ->  Index Scan using pk_film_id on films f  (cost=0.29..2.50 rows=1 width=13) (actual time=0.004..0.004 rows=1 loops=7)
        Index Cond: (id = fav.film_id)
Planning Time: 2.185 ms
Execution Time: 0.111 ms
 */

CREATE INDEX film_attribute_values_inx ON film_attribute_values (value);
EXPLAIN ANALYSE SELECT f.id, f.title, fav.value as value FROM films as f
    JOIN film_attribute_values fav on f.id = fav.film_id
        WHERE fav.value = 'value-fge';
/*
 Nested Loop  (cost=1.72..26.50 rows=7 width=23) (actual time=0.940..0.983 rows=7 loops=1)
  ->  Bitmap Heap Scan on film_attribute_values fav  (cost=1.44..8.98 rows=7 width=14) (actual time=0.916..0.929 rows=7 loops=1)
        Recheck Cond: (value = 'value-fge'::text)
        Heap Blocks: exact=6
        ->  Bitmap Index Scan on film_attribute_values_inx  (cost=0.00..1.44 rows=7 width=0) (actual time=0.904..0.905 rows=7 loops=1)
              Index Cond: (value = 'value-fge'::text)
  ->  Index Scan using pk_film_id on films f  (cost=0.29..2.50 rows=1 width=13) (actual time=0.006..0.006 rows=1 loops=7)
        Index Cond: (id = fav.film_id)
Planning Time: 4.914 ms
Execution Time: 1.035 ms
 */

------------------ 1 000 000------------------
DROP INDEX IF EXISTS films_rating_idx;
EXPLAIN ANALYZE SELECT avg(rating) FROM films WHERE rating > 0  and rating <= 50;
/*
 Finalize Aggregate  (cost=14661.89..14661.90 rows=1 width=32) (actual time=3601.218..3621.663 rows=1 loops=1)
  ->  Gather  (cost=14661.67..14661.88 rows=2 width=32) (actual time=3593.391..3621.638 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=13661.67..13661.68 rows=1 width=32) (actual time=3445.107..3445.109 rows=1 loops=3)
              ->  Parallel Seq Scan on films  (cost=0.00..12620.00 rows=416667 width=4) (actual time=2.472..3334.666 rows=333333 loops=3)
                    Filter: ((rating > 0) AND (rating <= 50))
Planning Time: 20.406 ms
Execution Time: 3621.746 ms
 */
CREATE INDEX films_rating_idx ON films (rating);
EXPLAIN ANALYZE SELECT avg(rating) FROM films WHERE rating > 0  and rating <= 50;
/*
Finalize Aggregate  (cost=14661.89..14661.90 rows=1 width=32) (actual time=5351.397..5386.842 rows=1 loops=1)
  ->  Gather  (cost=14661.67..14661.88 rows=2 width=32) (actual time=5350.528..5386.810 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=13661.67..13661.68 rows=1 width=32) (actual time=4854.377..4854.379 rows=1 loops=3)
              ->  Parallel Seq Scan on films  (cost=0.00..12620.00 rows=416667 width=4) (actual time=11.950..4661.648 rows=333333 loops=3)
                    Filter: ((rating > 0) AND (rating <= 50))
Planning Time: 10.651 ms
Execution Time: 5387.030 ms
*/

DROP INDEX IF EXISTS film_attribute_types_inx;
EXPLAIN ANALYSE SELECT f.id, f.title, fav.value as value FROM films as f
    JOIN film_attribute_values fav on f.id = fav.film_id
    JOIN film_attributes fa on fav.attribute_id = fa.id
    JOIN film_attribute_types fat on fat.id = fa.film_type_id
        WHERE fat.type = 'text';
/*
Gather  (cost=41403.29..73849.67 rows=200000 width=23) (actual time=2559.288..2732.527 rows=124568 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Hash Join  (cost=40403.29..52849.67 rows=83333 width=23) (actual time=2494.792..2644.350 rows=41523 loops=3)
        Hash Cond: (f.id = fav.film_id)
        ->  Parallel Seq Scan on films f  (cost=0.00..10536.67 rows=416667 width=13) (actual time=0.022..39.336 rows=333333 loops=3)
        ->  Parallel Hash  (cost=39361.62..39361.62 rows=83333 width=14) (actual time=2492.954..2492.958 rows=41523 loops=3)
              Buckets: 262144  Batches: 1  Memory Usage: 7936kB
              ->  Parallel Hash Join  (cost=27639.23..39361.62 rows=83333 width=14) (actual time=2217.729..2451.786 rows=41523 loops=3)
                    Hash Cond: (fav.attribute_id = fa.id)
                    ->  Parallel Seq Scan on film_attribute_values fav  (cost=0.00..9812.67 rows=416667 width=18) (actual time=3.548..71.947 rows=333333 loops=3)
                    ->  Parallel Hash  (cost=26597.57..26597.57 rows=83333 width=4) (actual time=2212.358..2212.360 rows=41630 loops=3)
                          Buckets: 262144  Batches: 1  Memory Usage: 6976kB
                          ->  Hash Join  (cost=1.07..26597.57 rows=83333 width=4) (actual time=3.393..2170.318 rows=41630 loops=3)
                                Hash Cond: (fa.film_type_id = fat.id)
                                ->  Parallel Seq Scan on film_attributes fa  (cost=0.00..24575.67 rows=416667 width=8) (actual time=2.375..2095.622 rows=333333 loops=3)
                                ->  Hash  (cost=1.06..1.06 rows=1 width=4) (actual time=0.974..0.975 rows=1 loops=3)
                                      Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                      ->  Seq Scan on film_attribute_types fat  (cost=0.00..1.06 rows=1 width=4) (actual time=0.959..0.961 rows=1 loops=3)
                                            Filter: ((type)::text = 'text'::text)
                                            Rows Removed by Filter: 4
Planning Time: 41.224 ms
Execution Time: 2740.095 ms
*/

CREATE INDEX film_attribute_types_inx ON film_attribute_types (type);
EXPLAIN ANALYSE SELECT f.id, f.title, fav.value as value FROM films as f
    JOIN film_attribute_values fav on f.id = fav.film_id
    JOIN film_attributes fa on fav.attribute_id = fa.id
    JOIN film_attribute_types fat on fat.id = fa.film_type_id
        WHERE fat.type = 'text';
/*
 Gather  (cost=41403.29..73849.67 rows=200000 width=23) (actual time=2259.577..2406.805 rows=124568 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Hash Join  (cost=40403.29..52849.67 rows=83333 width=23) (actual time=2196.030..2320.258 rows=41523 loops=3)
        Hash Cond: (f.id = fav.film_id)
        ->  Parallel Seq Scan on films f  (cost=0.00..10536.67 rows=416667 width=13) (actual time=0.011..32.739 rows=333333 loops=3)
        ->  Parallel Hash  (cost=39361.62..39361.62 rows=83333 width=14) (actual time=2194.740..2194.744 rows=41523 loops=3)
              Buckets: 262144  Batches: 1  Memory Usage: 7936kB
              ->  Parallel Hash Join  (cost=27639.23..39361.62 rows=83333 width=14) (actual time=2023.599..2171.153 rows=41523 loops=3)
                    Hash Cond: (fav.attribute_id = fa.id)
                    ->  Parallel Seq Scan on film_attribute_values fav  (cost=0.00..9812.67 rows=416667 width=18) (actual time=1.534..43.004 rows=333333 loops=3)
                    ->  Parallel Hash  (cost=26597.57..26597.57 rows=83333 width=4) (actual time=2021.184..2021.186 rows=41630 loops=3)
                          Buckets: 262144  Batches: 1  Memory Usage: 6976kB
                          ->  Hash Join  (cost=1.07..26597.57 rows=83333 width=4) (actual time=2.900..1988.276 rows=41630 loops=3)
                                Hash Cond: (fa.film_type_id = fat.id)
                                ->  Parallel Seq Scan on film_attributes fa  (cost=0.00..24575.67 rows=416667 width=8) (actual time=1.381..1918.934 rows=333333 loops=3)
                                ->  Hash  (cost=1.06..1.06 rows=1 width=4) (actual time=1.493..1.494 rows=1 loops=3)
                                      Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                      ->  Seq Scan on film_attribute_types fat  (cost=0.00..1.06 rows=1 width=4) (actual time=1.478..1.480 rows=1 loops=3)
                                            Filter: ((type)::text = 'text'::text)
                                            Rows Removed by Filter: 4
Planning Time: 51.061 ms
Execution Time: 2413.195 ms
 */

DROP INDEX IF EXISTS film_attribute_types_inx;
EXPLAIN ANALYSE SELECT f.id, f.title, fav.value as value FROM films as f
    JOIN film_attribute_values fav on f.id = fav.film_id
    JOIN film_attributes fa on fav.attribute_id = fa.id
    JOIN film_attribute_types fat on fat.id = fa.film_type_id
        WHERE fat.type = 'text';
/*
 Gather  (cost=41403.29..73849.67 rows=200000 width=23) (actual time=2148.057..2293.351 rows=124568 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Hash Join  (cost=40403.29..52849.67 rows=83333 width=23) (actual time=2073.812..2198.161 rows=41523 loops=3)
        Hash Cond: (f.id = fav.film_id)
        ->  Parallel Seq Scan on films f  (cost=0.00..10536.67 rows=416667 width=13) (actual time=0.011..32.536 rows=333333 loops=3)
        ->  Parallel Hash  (cost=39361.62..39361.62 rows=83333 width=14) (actual time=2070.960..2070.964 rows=41523 loops=3)
              Buckets: 262144  Batches: 1  Memory Usage: 7968kB
              ->  Parallel Hash Join  (cost=27639.23..39361.62 rows=83333 width=14) (actual time=1901.110..2048.320 rows=41523 loops=3)
                    Hash Cond: (fav.attribute_id = fa.id)
                    ->  Parallel Seq Scan on film_attribute_values fav  (cost=0.00..9812.67 rows=416667 width=18) (actual time=0.567..40.731 rows=333333 loops=3)
                    ->  Parallel Hash  (cost=26597.57..26597.57 rows=83333 width=4) (actual time=1898.525..1898.527 rows=41630 loops=3)
                          Buckets: 262144  Batches: 1  Memory Usage: 6976kB
                          ->  Hash Join  (cost=1.07..26597.57 rows=83333 width=4) (actual time=3.899..1865.304 rows=41630 loops=3)
                                Hash Cond: (fa.film_type_id = fat.id)
                                ->  Parallel Seq Scan on film_attributes fa  (cost=0.00..24575.67 rows=416667 width=8) (actual time=2.482..1794.871 rows=333333 loops=3)
                                ->  Hash  (cost=1.06..1.06 rows=1 width=4) (actual time=1.385..1.386 rows=1 loops=3)
                                      Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                      ->  Seq Scan on film_attribute_types fat  (cost=0.00..1.06 rows=1 width=4) (actual time=1.332..1.335 rows=1 loops=3)
                                            Filter: ((type)::text = 'text'::text)
                                            Rows Removed by Filter: 4
Planning Time: 21.967 ms
Execution Time: 2299.642 ms
 */

CREATE INDEX film_attribute_types_inx ON film_attribute_types (type);
EXPLAIN ANALYSE SELECT f.id, f.title, fav.value as value FROM films as f
    JOIN film_attribute_values fav on f.id = fav.film_id
    JOIN film_attributes fa on fav.attribute_id = fa.id
    JOIN film_attribute_types fat on fat.id = fa.film_type_id
        WHERE fat.type = 'text';
/*Gather  (cost=41403.29..73849.67 rows=200000 width=23) (actual time=2412.926..2585.891 rows=124568 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Hash Join  (cost=40403.29..52849.67 rows=83333 width=23) (actual time=2336.860..2486.886 rows=41523 loops=3)
        Hash Cond: (f.id = fav.film_id)
        ->  Parallel Seq Scan on films f  (cost=0.00..10536.67 rows=416667 width=13) (actual time=0.009..38.735 rows=333333 loops=3)
        ->  Parallel Hash  (cost=39361.62..39361.62 rows=83333 width=14) (actual time=2335.554..2335.558 rows=41523 loops=3)
              Buckets: 262144  Batches: 1  Memory Usage: 7936kB
              ->  Parallel Hash Join  (cost=27639.23..39361.62 rows=83333 width=14) (actual time=2161.788..2313.027 rows=41523 loops=3)
                    Hash Cond: (fav.attribute_id = fa.id)
                    ->  Parallel Seq Scan on film_attribute_values fav  (cost=0.00..9812.67 rows=416667 width=18) (actual time=0.643..42.269 rows=333333 loops=3)
                    ->  Parallel Hash  (cost=26597.57..26597.57 rows=83333 width=4) (actual time=2160.047..2160.049 rows=41630 loops=3)
                          Buckets: 262144  Batches: 1  Memory Usage: 6976kB
                          ->  Hash Join  (cost=1.07..26597.57 rows=83333 width=4) (actual time=5.672..2124.891 rows=41630 loops=3)
                                Hash Cond: (fa.film_type_id = fat.id)
                                ->  Parallel Seq Scan on film_attributes fa  (cost=0.00..24575.67 rows=416667 width=8) (actual time=2.969..2047.278 rows=333333 loops=3)
                                ->  Hash  (cost=1.06..1.06 rows=1 width=4) (actual time=2.677..2.678 rows=1 loops=3)
                                      Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                      ->  Seq Scan on film_attribute_types fat  (cost=0.00..1.06 rows=1 width=4) (actual time=2.651..2.654 rows=1 loops=3)
                                            Filter: ((type)::text = 'text'::text)
                                            Rows Removed by Filter: 4
Planning Time: 52.076 ms
Execution Time: 2593.425 ms
*/

DROP INDEX IF EXISTS film_attribute_values_inx;
EXPLAIN ANALYSE SELECT f.id, f.title, fav.value as value FROM films as f
    JOIN film_attribute_values fav on f.id = fav.film_id
        WHERE fav.value = 'value-fge';
/*Nested Loop  (cost=5.37..1090.25 rows=299 width=23) (actual time=2.316..6.316 rows=283 loops=1)
  ->  Bitmap Heap Scan on film_attribute_values fav  (cost=4.94..323.24 rows=299 width=14) (actual time=2.290..4.056 rows=283 loops=1)
        Recheck Cond: (value = 'value-fge'::text)
        Heap Blocks: exact=280
        ->  Bitmap Index Scan on film_attribute_values_idx  (cost=0.00..4.87 rows=299 width=0) (actual time=2.236..2.237 rows=283 loops=1)
              Index Cond: (value = 'value-fge'::text)
  ->  Index Scan using pk_film_id on films f  (cost=0.42..2.57 rows=1 width=13) (actual time=0.007..0.007 rows=1 loops=283)
        Index Cond: (id = fav.film_id)
Planning Time: 1.605 ms
Execution Time: 6.367 ms
*/

CREATE INDEX film_attribute_values_inx ON film_attribute_values (value);
EXPLAIN ANALYSE SELECT f.id, f.title, fav.value as value FROM films as f
    JOIN film_attribute_values fav on f.id = fav.film_id
        WHERE fav.value = 'value-fge';

/*
 Nested Loop  (cost=4.27..1089.15 rows=299 width=23) (actual time=2.920..5.255 rows=283 loops=1)
  ->  Bitmap Heap Scan on film_attribute_values fav  (cost=3.84..322.14 rows=299 width=14) (actual time=2.897..3.417 rows=283 loops=1)
        Recheck Cond: (value = 'value-fge'::text)
        Heap Blocks: exact=280
        ->  Bitmap Index Scan on film_attribute_values_inx  (cost=0.00..3.77 rows=299 width=0) (actual time=2.794..2.795 rows=283 loops=1)
              Index Cond: (value = 'value-fge'::text)
  ->  Index Scan using pk_film_id on films f  (cost=0.42..2.57 rows=1 width=13) (actual time=0.006..0.006 rows=1 loops=283)
        Index Cond: (id = fav.film_id)
Planning Time: 3.786 ms
Execution Time: 5.323 ms
 */

------------------ 10 000 000------------------
DROP INDEX IF EXISTS films_rating_idx;
EXPLAIN ANALYZE SELECT avg(rating) FROM films WHERE rating > 0  and rating <= 50;
/*
 Finalize Aggregate  (cost=132439.75..132439.76 rows=1 width=32) (actual time=7703.948..7713.785 rows=1 loops=1)
  ->  Gather  (cost=132439.53..132439.74 rows=2 width=32) (actual time=7703.629..7713.765 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=131439.53..131439.54 rows=1 width=32) (actual time=7548.754..7548.755 rows=1 loops=3)
              ->  Parallel Seq Scan on films  (cost=0.00..126195.72 rows=2097524 width=4) (actual time=37.057..7334.526 rows=1667300 loops=3)
                    Filter: ((rating > 0) AND (rating <= 50))
                    Rows Removed by Filter: 1666034
Planning Time: 42.993 ms
JIT:
  Functions: 17
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 12.113 ms, Inlining 0.000 ms, Optimization 17.431 ms, Emission 82.987 ms, Total 112.531 ms"
Execution Time: 7723.362 ms
 */

CREATE INDEX films_rating_idx ON films (rating);
EXPLAIN ANALYZE SELECT avg(rating) FROM films WHERE rating > 0  and rating <= 50;
/*
 Finalize Aggregate  (cost=82248.70..82248.71 rows=1 width=32) (actual time=2338.194..2348.509 rows=1 loops=1)
  ->  Gather  (cost=82248.49..82248.69 rows=2 width=32) (actual time=2337.671..2348.489 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=81248.49..81248.49 rows=1 width=32) (actual time=2280.442..2280.444 rows=1 loops=3)
              ->  Parallel Index Only Scan using films_rating_idx on films  (cost=0.43..76004.74 rows=2097500 width=4) (actual time=2.763..2127.129 rows=1667300 loops=3)
                    Index Cond: ((rating > 0) AND (rating <= 50))
                    Heap Fetches: 0
Planning Time: 3.882 ms
Execution Time: 2348.580 ms
 */
