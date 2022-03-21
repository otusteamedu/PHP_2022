# PHP_2022

## 1. Create tables in database - run SQL in "database.sql"

## 2. Create fake values in films, schedule, tickets and real values in halls and hall_places - run SQL in "data_generation.sql"
   - 100k rows in films (100,000 rows affected in 3 s 695 ms)
   - 1m rows in schedule (1,000,000 rows affected in 44 s 28 ms)
   - 10m rows in tickets (10,000,000 rows affected in 5 m 35 s 223 ms)

## 3. Run SQL queries in "requests.sql"
  ### Simple requests:
    - Get 20 tickets in current month" 
        20 rows retrieved starting from 1 in 8 s 265 ms (execution: 8 s 226 ms, fetching: 39 ms)
        Request took > 8s - bad result.
    - "Get 10 films with Duration more 2 hours and less 2.5 hours"
        10 rows retrieved starting from 1 in 87 ms (execution: 37 ms, fetching: 50 ms)
        Request took 87ms - Nice result, we're happy.
    - "Get 20 rows from schedule in Monday"
        10 rows retrieved starting from 1 in 64 ms (execution: 8 ms, fetching: 56 ms)
        Request took 64ms - Nice result, we're happy.

  ### Difficult requests:
    - "Get the most expensive in the IMAX ticket"
        1 row retrieved starting from 1 in 1 s 715 ms (execution: 1 s 698 ms, fetching: 17 ms)
        Request took ~ 1.6s - not good result.
    - "Get the most profitable film"
        1 row retrieved starting from 1 in 17 s 613 ms (execution: 17 s 601 ms, fetching: 12 ms)
        Request took > 17s - bad result.
    - "Get the longest film and the count of tickets sold for that film"
        1 row retrieved starting from 1 in 1 s 897 ms (execution: 1 s 878 ms, fetching: 19 ms)
        Request took ~ 2s - not good result.


## 4. We've 2 requests with bad response result. Try to explain and analyse these requests.
  ### 4.1 "Get 20 tickets in current month" > 8s
    QUERY PLAN:
        Limit  (cost=199531.34..199533.67 rows=20 width=25) (actual time=2799.668..2802.145 rows=20 loops=1)
          ->  Gather Merge  (cost=199531.34..199555.61 rows=208 width=25) (actual time=2799.667..2802.140 rows=20 loops=1)
                Workers Planned: 2
                Workers Launched: 2
                ->  Sort  (cost=198531.32..198531.58 rows=104 width=25) (actual time=2787.207..2787.209 rows=20 loops=3)
        "              Sort Key: ""Date"" DESC"
                      Sort Method: top-N heapsort  Memory: 27kB
                      Worker 0:  Sort Method: top-N heapsort  Memory: 27kB
                      Worker 1:  Sort Method: top-N heapsort  Memory: 27kB
                      ->  Parallel Seq Scan on tickets t  (cost=0.00..198528.55 rows=104 width=25) (actual time=0.081..2740.509 rows=284290 loops=3)
        "                    Filter: ((EXTRACT(year FROM ""Date"") = EXTRACT(year FROM now())) AND (EXTRACT(month FROM ""Date"") = EXTRACT(month FROM now())))"
                            Rows Removed by Filter: 3049044
        Planning Time: 0.086 ms
        Execution Time: 2802.188 ms

    Add index to "Date" column and 2 functional indexes (for year and month values)
        CREATE INDEX tickets_date_index on tickets ("Date");
        CREATE INDEX tickets_date_year_index on tickets (EXTRACT(YEAR FROM "Date"));
        CREATE INDEX tickets_date_month_index on tickets (EXTRACT(MONTH FROM "Date"));

    Check QUERY PLAN again and see that postgres use indexes for filtering data:
        Limit  (cost=2825.68..2825.73 rows=20 width=25) (actual time=3666.785..3666.792 rows=20 loops=1)
          ->  Sort  (cost=2825.68..2826.30 rows=250 width=25) (actual time=3666.784..3666.788 rows=20 loops=1)
        "        Sort Key: ""Date"" DESC"
                Sort Method: top-N heapsort  Memory: 27kB
                ->  Bitmap Heap Scan on tickets t  (cost=1855.25..2819.02 rows=250 width=25) (actual time=1061.053..3549.567 rows=852869 loops=1)
        "              Recheck Cond: ((EXTRACT(month FROM ""Date"") = EXTRACT(month FROM now())) AND (EXTRACT(year FROM ""Date"") = EXTRACT(year FROM now())))"
                      Rows Removed by Index Recheck: 4108868
                      Heap Blocks: exact=40505 lossy=33025
                      ->  BitmapAnd  (cost=1855.25..1855.25 rows=250 width=0) (actual time=1051.951..1051.953 rows=0 loops=1)
                            ->  Bitmap Index Scan on tickets_date_month_index  (cost=0.00..927.44 rows=50000 width=0) (actual time=94.382..94.383 rows=852869 loops=1)
        "                          Index Cond: (EXTRACT(month FROM ""Date"") = EXTRACT(month FROM now()))"
                            ->  Bitmap Index Scan on tickets_date_year_index  (cost=0.00..927.44 rows=50000 width=0) (actual time=954.223..954.223 rows=10000000 loops=1)
        "                          Index Cond: (EXTRACT(year FROM ""Date"") = EXTRACT(year FROM now()))"
        Planning Time: 0.112 ms
        Execution Time: 3667.423 ms

    Run request again:
        20 rows retrieved starting from 1 in 3 s 559 ms (execution: 3 s 527 ms, fetching: 32 ms)
        Request took ~ 3.5s - nice (but maybe better).

   ### 4.2 "Get the most profitable film" > 17s.
    QUERY PLAN:
        Limit  (cost=647855.20..647855.21 rows=1 width=58) (actual time=13390.177..13548.118 rows=1 loops=1)
          ->  Sort  (cost=647855.20..648091.55 rows=94537 width=58) (actual time=13390.176..13548.117 rows=1 loops=1)
        "        Sort Key: (sum(tickets.""Amount"")) DESC"
                Sort Method: top-N heapsort  Memory: 25kB
                ->  Finalize GroupAggregate  (cost=622722.58..647382.52 rows=94537 width=58) (actual time=11926.248..13518.236 rows=98143 loops=1)
        "              Group Key: films.""Title"""
                      ->  Gather Merge  (cost=622722.58..644782.75 rows=189074 width=58) (actual time=11926.215..13133.562 rows=286149 loops=1)
                            Workers Planned: 2
                            Workers Launched: 2
                            ->  Sort  (cost=621722.55..621958.90 rows=94537 width=58) (actual time=11871.254..12502.697 rows=95383 loops=3)
        "                          Sort Key: films.""Title"""
                                  Sort Method: external merge  Disk: 8688kB
                                  Worker 0:  Sort Method: external merge  Disk: 8656kB
                                  Worker 1:  Sort Method: external merge  Disk: 8704kB
                                  ->  Partial HashAggregate  (cost=552205.87..610353.74 rows=94537 width=58) (actual time=7161.587..8970.991 rows=95383 loops=3)
        "                                Group Key: films.""Title"""
                                        Planned Partitions: 8  Batches: 41  Memory Usage: 4305kB  Disk Usage: 146080kB
                                        Worker 0:  Batches: 41  Memory Usage: 4305kB  Disk Usage: 153120kB
                                        Worker 1:  Batches: 41  Memory Usage: 4305kB  Disk Usage: 154120kB
                                        ->  Parallel Hash Join  (cost=28450.80..220174.60 rows=4166667 width=31) (actual time=2934.580..4780.703 rows=3333333 loops=3)
        "                                      Hash Cond: (tickets.""Schedule_ID"" = schedule.""ID"")"
                                              ->  Parallel Seq Scan on tickets  (cost=0.00..115196.67 rows=4166667 width=9) (actual time=0.065..874.615 rows=3333333 loops=3)
                                              ->  Parallel Hash  (cost=20393.46..20393.46 rows=416667 width=30) (actual time=708.306..708.308 rows=333333 loops=3)
                                                    Buckets: 65536  Batches: 32  Memory Usage: 2560kB
                                                    ->  Hash Join  (cost=3840.00..20393.46 rows=416667 width=30) (actual time=85.029..480.408 rows=333333 loops=3)
        "                                                  Hash Cond: (schedule.""Film_ID"" = films.""ID"")"
                                                          ->  Parallel Seq Scan on schedule  (cost=0.00..11519.67 rows=416667 width=8) (actual time=0.237..120.394 rows=333333 loops=3)
                                                          ->  Hash  (cost=1906.00..1906.00 rows=100000 width=30) (actual time=83.377..83.378 rows=100000 loops=3)
                                                                Buckets: 65536  Batches: 2  Memory Usage: 3620kB
                                                                ->  Seq Scan on films  (cost=0.00..1906.00 rows=100000 width=30) (actual time=0.043..23.105 rows=100000 loops=3)
        Planning Time: 0.362 ms
        Execution Time: 13572.001 ms

    Add index to "Amount" and "Title" columns in tickets and films tables
        CREATE INDEX tickets_amount_index on tickets ("Amount");
        CREATE INDEX films_title_index on films ("Title");

    Check QUERY PLAN again and see that postgres still doesn't using our indexes =( :
        Limit  (cost=647855.20..647855.21 rows=1 width=58) (actual time=11276.364..11388.777 rows=1 loops=1)
          ->  Sort  (cost=647855.20..648091.55 rows=94537 width=58) (actual time=11276.363..11388.775 rows=1 loops=1)
        "        Sort Key: (sum(tickets.""Amount"")) DESC"
                Sort Method: top-N heapsort  Memory: 25kB
                ->  Finalize GroupAggregate  (cost=622722.58..647382.52 rows=94537 width=58) (actual time=10078.750..11360.365 rows=98143 loops=1)
        "              Group Key: films.""Title"""
                      ->  Gather Merge  (cost=622722.58..644782.75 rows=189074 width=58) (actual time=10078.733..11035.323 rows=286290 loops=1)
                            Workers Planned: 2
                            Workers Launched: 2
                            ->  Sort  (cost=621722.55..621958.90 rows=94537 width=58) (actual time=10008.052..10512.804 rows=95430 loops=3)
        "                          Sort Key: films.""Title"""
                                  Sort Method: external merge  Disk: 8712kB
                                  Worker 0:  Sort Method: external merge  Disk: 8640kB
                                  Worker 1:  Sort Method: external merge  Disk: 8688kB
                                  ->  Partial HashAggregate  (cost=552205.87..610353.74 rows=94537 width=58) (actual time=6023.160..7487.223 rows=95430 loops=3)
        "                                Group Key: films.""Title"""
                                        Planned Partitions: 8  Batches: 41  Memory Usage: 4305kB  Disk Usage: 152200kB
                                        Worker 0:  Batches: 41  Memory Usage: 4305kB  Disk Usage: 153096kB
                                        Worker 1:  Batches: 41  Memory Usage: 4305kB  Disk Usage: 146336kB
                                        ->  Parallel Hash Join  (cost=28450.80..220174.60 rows=4166667 width=31) (actual time=2503.464..4172.107 rows=3333333 loops=3)
        "                                      Hash Cond: (tickets.""Schedule_ID"" = schedule.""ID"")"
                                              ->  Parallel Seq Scan on tickets  (cost=0.00..115196.67 rows=4166667 width=9) (actual time=0.062..775.833 rows=3333333 loops=3)
                                              ->  Parallel Hash  (cost=20393.46..20393.46 rows=416667 width=30) (actual time=585.097..585.099 rows=333333 loops=3)
                                                    Buckets: 65536  Batches: 32  Memory Usage: 2560kB
                                                    ->  Hash Join  (cost=3840.00..20393.46 rows=416667 width=30) (actual time=58.720..393.011 rows=333333 loops=3)
        "                                                  Hash Cond: (schedule.""Film_ID"" = films.""ID"")"
                                                          ->  Parallel Seq Scan on schedule  (cost=0.00..11519.67 rows=416667 width=8) (actual time=0.040..72.212 rows=333333 loops=3)
                                                          ->  Hash  (cost=1906.00..1906.00 rows=100000 width=30) (actual time=58.207..58.208 rows=100000 loops=3)
                                                                Buckets: 65536  Batches: 2  Memory Usage: 3620kB
                                                                ->  Seq Scan on films  (cost=0.00..1906.00 rows=100000 width=30) (actual time=0.021..22.496 rows=100000 loops=3)
        Planning Time: 0.215 ms
        Execution Time: 11445.364 ms

    Try to update "random_page_cost = 1.05" in postgres configuration and get QUERY PLAN:
        Limit  (cost=478306.46..478306.46 rows=1 width=58) (actual time=8587.325..8700.960 rows=1 loops=1)
          ->  Sort  (cost=478306.46..478542.80 rows=94537 width=58) (actual time=8587.323..8700.958 rows=1 loops=1)
        "        Sort Key: (sum(tickets.""Amount"")) DESC"
                Sort Method: top-N heapsort  Memory: 25kB
                ->  Finalize GroupAggregate  (cost=453173.83..477833.78 rows=94537 width=58) (actual time=7906.027..8680.209 rows=98143 loops=1)
        "              Group Key: films.""Title"""
                      ->  Gather Merge  (cost=453173.83..475234.01 rows=189074 width=58) (actual time=7906.002..8510.238 rows=286514 loops=1)
                            Workers Planned: 2
                            Workers Launched: 2
                            ->  Sort  (cost=452173.81..452410.15 rows=94537 width=58) (actual time=7875.051..8158.976 rows=95505 loops=3)
        "                          Sort Key: films.""Title"""
                                  Sort Method: external merge  Disk: 8632kB
                                  Worker 0:  Sort Method: external merge  Disk: 8728kB
                                  Worker 1:  Sort Method: external merge  Disk: 8712kB
                                  ->  Partial HashAggregate  (cost=384155.73..442303.59 rows=94537 width=58) (actual time=5278.083..6193.150 rows=95505 loops=3)
        "                                Group Key: films.""Title"""
                                        Planned Partitions: 8  Batches: 41  Memory Usage: 4305kB  Disk Usage: 151056kB
                                        Worker 0:  Batches: 41  Memory Usage: 4305kB  Disk Usage: 153200kB
                                        Worker 1:  Batches: 41  Memory Usage: 4305kB  Disk Usage: 148056kB
                                        ->  Parallel Hash Join  (cost=28450.80..220174.60 rows=4166667 width=31) (actual time=2892.466..4044.761 rows=3333333 loops=3)
        "                                      Hash Cond: (tickets.""Schedule_ID"" = schedule.""ID"")"
                                              ->  Parallel Seq Scan on tickets  (cost=0.00..115196.67 rows=4166667 width=9) (actual time=0.052..1394.221 rows=3333333 loops=3)
                                              ->  Parallel Hash  (cost=20393.46..20393.46 rows=416667 width=30) (actual time=658.396..658.398 rows=333333 loops=3)
                                                    Buckets: 65536  Batches: 32  Memory Usage: 2560kB
                                                    ->  Hash Join  (cost=3840.00..20393.46 rows=416667 width=30) (actual time=44.239..514.128 rows=333333 loops=3)
        "                                                  Hash Cond: (schedule.""Film_ID"" = films.""ID"")"
                                                          ->  Parallel Seq Scan on schedule  (cost=0.00..11519.67 rows=416667 width=8) (actual time=0.415..270.165 rows=333333 loops=3)
                                                          ->  Hash  (cost=1906.00..1906.00 rows=100000 width=30) (actual time=43.451..43.452 rows=100000 loops=3)
                                                                Buckets: 65536  Batches: 2  Memory Usage: 3620kB
                                                                ->  Seq Scan on films  (cost=0.00..1906.00 rows=100000 width=30) (actual time=0.117..16.613 rows=100000 loops=3)
        Planning Time: 12.118 ms
        Execution Time: 8719.623 ms

    Now the SQL request took ~11.5s, it's still bad.
    Try to update count of workers in parallels "max_parallel_workers_per_gather = 8" and again check QUERY PLAN:
        Limit  (cost=368425.75..368425.75 rows=1 width=58) (actual time=5738.265..5901.485 rows=1 loops=1)
          ->  Sort  (cost=368425.75..368662.09 rows=94537 width=58) (actual time=5738.264..5901.483 rows=1 loops=1)
        "        Sort Key: (sum(tickets.""Amount"")) DESC"
                Sort Method: top-N heapsort  Memory: 25kB
                ->  Finalize GroupAggregate  (cost=318657.83..367953.06 rows=94537 width=58) (actual time=4823.433..5881.120 rows=98143 loops=1)
        "              Group Key: films.""Title"""
                      ->  Gather Merge  (cost=318657.83..363935.24 rows=378148 width=58) (actual time=4823.410..5647.861 rows=444227 loops=1)
                            Workers Planned: 4
                            Workers Launched: 4
                            ->  Sort  (cost=317657.77..317894.11 rows=94537 width=58) (actual time=4769.238..5029.021 rows=88845 loops=5)
        "                          Sort Key: films.""Title"""
                                  Sort Method: external merge  Disk: 7872kB
                                  Worker 0:  Sort Method: external merge  Disk: 8008kB
                                  Worker 1:  Sort Method: external merge  Disk: 8072kB
                                  Worker 2:  Sort Method: external merge  Disk: 8120kB
                                  Worker 3:  Sort Method: external merge  Disk: 8096kB
                                  ->  Partial HashAggregate  (cost=272426.15..307787.55 rows=94537 width=58) (actual time=2710.527..3287.881 rows=88845 loops=5)
        "                                Group Key: films.""Title"""
                                        Planned Partitions: 8  Batches: 41  Memory Usage: 4305kB  Disk Usage: 88824kB
                                        Worker 0:  Batches: 41  Memory Usage: 4305kB  Disk Usage: 88768kB
                                        Worker 1:  Batches: 41  Memory Usage: 4305kB  Disk Usage: 88792kB
                                        Worker 2:  Batches: 41  Memory Usage: 4305kB  Disk Usage: 96968kB
                                        Worker 3:  Batches: 45  Memory Usage: 4305kB  Disk Usage: 88944kB
                                        ->  Parallel Hash Join  (cost=28450.80..174037.48 rows=2500000 width=31) (actual time=1199.153..1861.179 rows=2000000 loops=5)
        "                                      Hash Cond: (tickets.""Schedule_ID"" = schedule.""ID"")"
                                              ->  Parallel Seq Scan on tickets  (cost=0.00..98530.00 rows=2500000 width=9) (actual time=0.075..322.168 rows=2000000 loops=5)
                                              ->  Parallel Hash  (cost=20393.46..20393.46 rows=416667 width=30) (actual time=276.840..276.842 rows=200000 loops=5)
                                                    Buckets: 65536  Batches: 32  Memory Usage: 2624kB
                                                    ->  Hash Join  (cost=3840.00..20393.46 rows=416667 width=30) (actual time=44.218..191.910 rows=200000 loops=5)
        "                                                  Hash Cond: (schedule.""Film_ID"" = films.""ID"")"
                                                          ->  Parallel Seq Scan on schedule  (cost=0.00..11519.67 rows=416667 width=8) (actual time=0.050..32.130 rows=200000 loops=5)
                                                          ->  Hash  (cost=1906.00..1906.00 rows=100000 width=30) (actual time=43.790..43.790 rows=100000 loops=5)
                                                                Buckets: 65536  Batches: 2  Memory Usage: 3620kB
                                                                ->  Seq Scan on films  (cost=0.00..1906.00 rows=100000 width=30) (actual time=0.029..14.742 rows=100000 loops=5)
        Planning Time: 0.279 ms
        Execution Time: 5933.963 ms

    Yes, now the QUERY PLAN works more faster and using 4 workers in parallel, but the origin request still took ~11.5s
    I think it must be fixed by another way: use the material view and trigger which will update it.

## Top 15 biggest objects in database

| name                            | totalsize | relsize    |
|---------------------------------|-----------|------------|
| public.tickets                  | 1284 MB   | 574 MB     |
| public.tickets_amount_index     | 215 MB    | 215 MB     |
| public.tickets_date_month_index | 215 MB    | 215 MB     |
| public.tickets_pkey             | 214 MB    | 214 MB     |
| public.schedule                 | 79 MB     | 57 MB      |
| public.tickets_date_index       | 66 MB     | 66 MB      |
| public.schedule_pkey            | 21 MB     | 21 MB      |
| public.films                    | 14 MB     | 7248 kB    |
| public.films_title_index        | 4592 kB   | 4592 kB    |
| public.films_pkey               | 2208 kB   | 2208 kB    |
| pg_toast.pg_toast_2618          | 552 kB    | 504 kB     |
| pg_toast.pg_toast_2619          | 88 kB     | 40 kB      |
| pg_toast.pg_toast_1255          | 56 kB     | 8192 bytes |
| public.halls                    | 24 kB     | 8192 bytes |
| public.hall_places              | 24 kB     | 8192 bytes |
