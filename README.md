# PHP_2022

# Query report
# Without index
Group  (cost=18241.00..18244.65 rows=15 width=8) (actual time=120.861..124.349 rows=5 loops=1)
"  Group Key: orders.hall_id, orders.film_id"
->  Gather Merge  (cost=18241.00..18244.50 rows=30 width=8) (actual time=120.860..124.344 rows=15 loops=1)
Workers Planned: 2
Workers Launched: 2
->  Sort  (cost=17240.97..17241.01 rows=15 width=8) (actual time=118.309..118.312 rows=5 loops=3)
"              Sort Key: orders.hall_id, orders.film_id"
Sort Method: quicksort  Memory: 25kB
Worker 0:  Sort Method: quicksort  Memory: 25kB
Worker 1:  Sort Method: quicksort  Memory: 25kB
->  Partial HashAggregate  (cost=17240.53..17240.68 rows=15 width=8) (actual time=118.289..118.292 rows=5 loops=3)
"                    Group Key: orders.hall_id, orders.film_id"
Batches: 1  Memory Usage: 24kB
Worker 0:  Batches: 1  Memory Usage: 24kB
Worker 1:  Batches: 1  Memory Usage: 24kB
->  Hash Join  (cost=38.07..16468.38 rows=154429 width=8) (actual time=0.073..95.168 rows=123691 loops=3)
Hash Cond: (orders.film_id = f.id)
->  Hash Join  (cost=37.00..15489.27 rows=154429 width=8) (actual time=0.027..71.467 rows=123691 loops=3)
Hash Cond: (orders.hall_id = h.id)
->  Parallel Seq Scan on orders  (cost=0.00..15045.46 rows=154429 width=8) (actual time=0.009..44.078 rows=123691 loops=3)
Filter: (film_id > 2)
Rows Removed by Filter: 246643
->  Hash  (cost=22.00..22.00 rows=1200 width=4) (actual time=0.009..0.010 rows=5 loops=3)
Buckets: 2048  Batches: 1  Memory Usage: 17kB
->  Seq Scan on halls h  (cost=0.00..22.00 rows=1200 width=4) (actual time=0.006..0.007 rows=5 loops=3)
->  Hash  (cost=1.03..1.03 rows=3 width=4) (actual time=0.014..0.015 rows=3 loops=3)
Buckets: 1024  Batches: 1  Memory Usage: 9kB
->  Seq Scan on films f  (cost=0.00..1.03 rows=3 width=4) (actual time=0.009..0.010 rows=3 loops=3)

Planning Time: 0.333 ms
Execution Time: 124.404 ms


# With index
Group  (cost=16844.76..16848.41 rows=15 width=8) (actual time=81.561..82.671 rows=5 loops=1)
"  Group Key: orders.hall_id, orders.film_id"
->  Gather Merge  (cost=16844.76..16848.26 rows=30 width=8) (actual time=81.559..82.667 rows=15 loops=1)
Workers Planned: 2
Workers Launched: 2
->  Sort  (cost=15844.73..15844.77 rows=15 width=8) (actual time=78.666..78.669 rows=5 loops=3)
"              Sort Key: orders.hall_id, orders.film_id"
Sort Method: quicksort  Memory: 25kB
Worker 0:  Sort Method: quicksort  Memory: 25kB
Worker 1:  Sort Method: quicksort  Memory: 25kB
->  Partial HashAggregate  (cost=15844.29..15844.44 rows=15 width=8) (actual time=78.644..78.648 rows=5 loops=3)
"                    Group Key: orders.hall_id, orders.film_id"
Batches: 1  Memory Usage: 24kB
Worker 0:  Batches: 1  Memory Usage: 24kB
Worker 1:  Batches: 1  Memory Usage: 24kB
->  Hash Join  (cost=38.49..15072.14 rows=154429 width=8) (actual time=0.158..57.111 rows=123691 loops=3)
Hash Cond: (orders.film_id = f.id)
->  Hash Join  (cost=37.43..14093.03 rows=154429 width=8) (actual time=0.108..34.989 rows=123691 loops=3)
Hash Cond: (orders.hall_id = h.id)
->  Parallel Index Only Scan using orders_index on orders  (cost=0.43..13649.22 rows=154429 width=8) (actual time=0.090..12.459 rows=123691 loops=3)
Index Cond: (film_id > 2)
Heap Fetches: 0
->  Hash  (cost=22.00..22.00 rows=1200 width=4) (actual time=0.009..0.010 rows=5 loops=3)
Buckets: 2048  Batches: 1  Memory Usage: 17kB
->  Seq Scan on halls h  (cost=0.00..22.00 rows=1200 width=4) (actual time=0.005..0.006 rows=5 loops=3)
->  Hash  (cost=1.03..1.03 rows=3 width=4) (actual time=0.014..0.014 rows=3 loops=3)
Buckets: 1024  Batches: 1  Memory Usage: 9kB
->  Seq Scan on films f  (cost=0.00..1.03 rows=3 width=4) (actual time=0.010..0.011 rows=3 loops=3)

Planning Time: 0.375 ms
Execution Time: 82.726 ms




