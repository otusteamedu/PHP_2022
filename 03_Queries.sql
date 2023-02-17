-- 1. Выбор всех фильмов на сегодня

-- 1.1. Если оставить "простой" запрос, то вывести можно только ID фильмов.
    SELECT s.movie_id
    FROM public."session" s 
    WHERE s.start_time = CURRENT_DATE;

-- 1.1.1. План на 1000+ строк

    /*
    Seq Scan on session s  (cost=0.00..25.50 rows=5 width=4) (actual time=0.011..0.170 rows=12 loops=1)
        Filter: (start_time = CURRENT_DATE)
        Rows Removed by Filter: 988
    Planning Time: 0.060 ms
    Execution Time: 0.179 ms
    */

-- 1.1.2. План на 100000+ строк

    /*
    Seq Scan on session s  (cost=0.00..2486.00 rows=500 width=4) (actual time=0.012..29.956 rows=1083 loops=1)
        Filter: (start_time = CURRENT_DATE)
        Rows Removed by Filter: 98917
    Planning Time: 0.067 ms
    Execution Time: 30.054 ms
    */

    CREATE INDEX session_start_time_idx ON public."session" (start_time);

-- 1.1.3. План на 100000+ строк, после создания индекса

    /*
    Bitmap Heap Scan on session s  (cost=4.64..149.04 rows=45 width=4) (actual time=0.017..0.037 rows=23 loops=1)
        Recheck Cond: (start_time = CURRENT_DATE)
        Heap Blocks: exact=23
        ->  Bitmap Index Scan on session_start_time_idx  (cost=0.00..4.63 rows=45 width=0) (actual time=0.012..0.012 rows=23 loops=1)
                Index Cond: (start_time = CURRENT_DATE)
    Planning Time: 0.066 ms
    Execution Time: 0.057 ms
    */

-- 1.2. На проде, конечно будет отбираться вся необходимая информаци о фильмах.

    SELECT m.title, m.image_url, m.description
    FROM public."session" s 
    INNER JOIN public.movie m 
        ON m.id = s.movie_id 
    WHERE s.start_time = CURRENT_DATE;

-- 1.2.1. План на 1000+ строк

    /*
    Hash Join  (cost=4.25..29.76 rows=5 width=72) (actual time=0.063..0.218 rows=12 loops=1)
        Hash Cond: (s.movie_id = m.id)
        ->  Seq Scan on session s  (cost=0.00..25.50 rows=5 width=4) (actual time=0.007..0.156 rows=12 loops=1)
                Filter: (start_time = CURRENT_DATE)
                Rows Removed by Filter: 988
        ->  Hash  (cost=3.00..3.00 rows=100 width=76) (actual time=0.051..0.052 rows=100 loops=1)
                Buckets: 1024  Batches: 1  Memory Usage: 19kB
                ->  Seq Scan on movie m  (cost=0.00..3.00 rows=100 width=76) (actual time=0.003..0.025 rows=100 loops=1)
    Planning Time: 0.169 ms
    Execution Time: 0.233 ms
    */

    DROP INDEX IF EXISTS session_start_time_idx;

-- 1.2.2. План на 100000+ строк

    /*
    Hash Join  (cost=4.25..2491.62 rows=500 width=72) (actual time=0.069..35.998 rows=1083 loops=1)
        Hash Cond: (s.movie_id = m.id)
        ->  Seq Scan on session s  (cost=0.00..2486.00 rows=500 width=4) (actual time=0.010..34.414 rows=1083 loops=1)
                Filter: (start_time = CURRENT_DATE)
                Rows Removed by Filter: 98917
        ->  Hash  (cost=3.00..3.00 rows=100 width=76) (actual time=0.054..0.056 rows=100 loops=1)
                Buckets: 1024  Batches: 1  Memory Usage: 19kB
                ->  Seq Scan on movie m  (cost=0.00..3.00 rows=100 width=76) (actual time=0.004..0.026 rows=100 loops=1)
    Planning Time: 0.181 ms
    Execution Time: 36.181 ms
    */

    CREATE INDEX session_start_time_idx ON public."session" (start_time);
    CREATE INDEX session_movie_id_idx ON public."session" (movie_id);

-- 1.1.3. План на 100000+ строк, после создания индексов

    /*
    Hash Join  (cost=8.89..153.41 rows=45 width=72) (actual time=0.130..0.177 rows=23 loops=1)
        Hash Cond: (s.movie_id = m.id)
        ->  Bitmap Heap Scan on session s  (cost=4.64..149.04 rows=45 width=4) (actual time=0.018..0.051 rows=23 loops=1)
                Recheck Cond: (start_time = CURRENT_DATE)
                Heap Blocks: exact=23
                ->  Bitmap Index Scan on session_start_time_idx  (cost=0.00..4.63 rows=45 width=0) (actual time=0.012..0.012 rows=23 loops=1)
                    Index Cond: (start_time = CURRENT_DATE)
        ->  Hash  (cost=3.00..3.00 rows=100 width=76) (actual time=0.106..0.106 rows=100 loops=1)
                Buckets: 1024  Batches: 1  Memory Usage: 19kB
                ->  Seq Scan on movie m  (cost=0.00..3.00 rows=100 width=76) (actual time=0.006..0.071 rows=100 loops=1)
    Planning Time: 0.252 ms
    Execution Time: 0.204 ms
    */

    DROP INDEX IF EXISTS session_start_time_idx;
    DROP INDEX IF EXISTS session_movie_id_idx;


-- 2. Подсчёт проданных билетов за неделю
    SELECT COUNT(t.id)
    FROM public.ticket t 
    WHERE t.created_at >= CURRENT_DATE - interval '7 days'
        AND t.created_at <= CURRENT_DATE;

-- 2.1. План на 10000+ строк

    /*    
    Aggregate  (cost=3585.25..3585.26 rows=1 width=8) (actual time=43.497..43.498 rows=1 loops=1)
        ->  Seq Scan on ticket t  (cost=0.00..3584.00 rows=500 width=4) (actual time=0.014..42.358 rows=9857 loops=1)
                Filter: (((created_at) <= CURRENT_DATE) AND ((created_at) >= (CURRENT_DATE - '7 days'::interval)))
                Rows Removed by Filter: 90143
    Planning Time: 0.076 ms
    Execution Time: 43.520 ms
    */

-- 2.2. План на 10000000+ строк

    /*
    Finalize Aggregate  (cost=198968.00..198968.01 rows=1 width=8) (actual time=4114.865..4134.594 rows=1 loops=1)
        ->  Gather  (cost=198967.79..198968.00 rows=2 width=8) (actual time=4114.744..4134.582 rows=3 loops=1)
                Workers Planned: 2
                Workers Launched: 2
                ->  Partial Aggregate  (cost=197967.79..197967.80 rows=1 width=8) (actual time=4077.431..4077.432 rows=1 loops=3)
                    ->  Parallel Seq Scan on ticket t  (cost=0.00..197915.71 rows=20833 width=4) (actual time=57.861..4055.235 rows=297663 loops=3)
                            Filter: (((created_at) <= CURRENT_DATE) AND ((created_at) >= (CURRENT_DATE - '7 days'::interval)))
                            Rows Removed by Filter: 3035670
    Planning Time: 1.476 ms
        JIT:
        Functions: 17
        Options: Inlining false, Optimization false, Expressions true, Deforming true
        Timing: Generation 2.474 ms, Inlining 0.000 ms, Optimization 20.575 ms, Emission 138.970 ms, Total 162.018 ms
    Execution Time: 4460.375 ms
    */

    CREATE INDEX ticket_created_at_idx ON public.ticket (created_at);

-- 2.3. План на 10000000+ строк, после создания индекса

    /*
    Finalize Aggregate  (cost=155860.09..155860.10 rows=1 width=8) (actual time=654.270..658.176 rows=1 loops=1)
        ->  Gather  (cost=155859.87..155860.08 rows=2 width=8) (actual time=653.879..658.164 rows=3 loops=1)
                Workers Planned: 2
                Workers Launched: 2
                ->  Partial Aggregate  (cost=154859.87..154859.88 rows=1 width=8) (actual time=622.686..622.687 rows=1 loops=3)
                    ->  Parallel Bitmap Heap Scan on ticket t  (cost=10880.92..154031.78 rows=331239 width=4) (actual time=50.027..596.383 rows=261602 loops=3)
                            Recheck Cond: ((created_at >= (CURRENT_DATE - '7 days'::interval)) AND (created_at <= CURRENT_DATE))
                            Rows Removed by Index Recheck: 1218391
                            Heap Blocks: exact=17045 lossy=11140
                            ->  Bitmap Index Scan on ticket_created_at_idx  (cost=0.00..10682.17 rows=794973 width=0) (actual time=70.489..70.489 rows=784805 loops=1)
                                Index Cond: ((created_at >= (CURRENT_DATE - '7 days'::interval)) AND (created_at <= CURRENT_DATE))
    Planning Time: 0.112 ms
        JIT:
        Functions: 23
        Options: Inlining false, Optimization false, Expressions true, Deforming true
        Timing: Generation 3.866 ms, Inlining 0.000 ms, Optimization 1.083 ms, Emission 14.950 ms, Total 19.899 ms
    Execution Time: 659.925 ms
    */

    DROP INDEX IF EXISTS ticket_created_at_idx;

-- 3. Формирование афиши (фильмы, которые показывают на этой неделе)

-- 3.1. Если оставить "простой" запрос, то вывести можно только ID фильмов и залов.

    SELECT s.movie_id, s.hall_id, s.start_time, s.price 
    FROM public."session" s 
    WHERE s.start_time >= CURRENT_DATE - interval '7 days'
        AND s.start_time <= CURRENT_DATE
    ORDER BY 
        s.movie_id,
        s.hall_id,
        s.start_time;

-- 3.1.1. План запроса на 1000+ строк

    /*
    Sort  (cost=35.56..35.57 rows=5 width=20) (actual time=0.287..0.292 rows=102 loops=1)
        Sort Key: movie_id, hall_id, start_time
        Sort Method: quicksort  Memory: 31kB
        ->  Seq Scan on session s  (cost=0.00..35.50 rows=5 width=20) (actual time=0.016..0.256 rows=102 loops=1)
                Filter: (((start_time) <= CURRENT_DATE) AND ((start_time) >= (CURRENT_DATE - '7 days'::interval)))
                Rows Removed by Filter: 898
    Planning Time: 0.064 ms
    Execution Time: 0.309 ms
    */

-- 3.1.2. План запроса на 100000+ строк

    /*
    Sort  (cost=3508.41..3509.66 rows=500 width=20) (actual time=37.500..37.969 rows=8835 loops=1)
        Sort Key: movie_id, hall_id, start_time
        Sort Method: quicksort  Memory: 937kB
        ->  Seq Scan on session s  (cost=0.00..3486.00 rows=500 width=20) (actual time=0.015..32.797 rows=8835 loops=1)
                Filter: (((start_time) <= CURRENT_DATE) AND ((start_time) >= (CURRENT_DATE - '7 days'::interval)))
                Rows Removed by Filter: 91165
    Planning Time: 0.079 ms
    Execution Time: 38.281 ms
    */    

    CREATE INDEX session_start_time_idx ON public."session" (start_time);

-- 3.1.3. План запроса на 100000+ строк, после создания индекса

    /*
    Sort  (cost=1514.68..1533.96 rows=7711 width=20) (actual time=5.805..6.218 rows=7737 loops=1)
        Sort Key: movie_id, hall_id, start_time
        Sort Method: quicksort  Memory: 676kB
        ->  Bitmap Heap Scan on session s  (cost=107.34..1016.84 rows=7711 width=20) (actual time=0.347..2.708 rows=7737 loops=1)
                Recheck Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time <= CURRENT_DATE))
                Heap Blocks: exact=736
                ->  Bitmap Index Scan on session_start_time_idx  (cost=0.00..105.41 rows=7711 width=0) (actual time=0.270..0.270 rows=7737 loops=1)
                    Index Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time <= CURRENT_DATE))
    Planning Time: 0.098 ms
    Execution Time: 6.509 ms
    */

    DROP INDEX IF EXISTS session_start_time_idx;

-- 3.2. На проде, конечно будет отбираться вся необходимая информаци о фильмах.

    SELECT m.title, m.image_url, m.description, h.title, s.start_time, s.price 
    FROM public."session" s 
    INNER JOIN public.movie m 
        ON m.id = s.movie_id 
    INNER JOIN public.hall h 
        ON h.id = s.hall_id 
    WHERE s.start_time >= CURRENT_DATE - interval '7 days'
        AND s.start_time <= CURRENT_DATE
    ORDER BY 
        m.title,
        h.title,
        s.start_time;

-- 3.2.1. План запроса на 1000+ строк

    /*
    Sort  (cost=60.82..60.83 rows=5 width=116) (actual time=0.917..0.928 rows=102 loops=1)
        Sort Key: m.title, h.title, s.start_time
        Sort Method: quicksort  Memory: 39kB
        ->  Nested Loop  (cost=4.41..60.76 rows=5 width=116) (actual time=0.094..0.743 rows=102 loops=1)
                ->  Hash Join  (cost=4.25..39.76 rows=5 width=88) (actual time=0.082..0.618 rows=102 loops=1)
                    Hash Cond: (s.movie_id = m.id)
                    ->  Seq Scan on session s  (cost=0.00..35.50 rows=5 width=20) (actual time=0.013..0.489 rows=102 loops=1)
                            Filter: (((start_time) <= CURRENT_DATE) AND ((start_time) >= (CURRENT_DATE - '7 days'::interval)))
                            Rows Removed by Filter: 898
                    ->  Hash  (cost=3.00..3.00 rows=100 width=76) (actual time=0.064..0.065 rows=100 loops=1)
                            Buckets: 1024  Batches: 1  Memory Usage: 19kB
                            ->  Seq Scan on movie m  (cost=0.00..3.00 rows=100 width=76) (actual time=0.006..0.033 rows=100 loops=1)
                ->  Memoize  (cost=0.16..4.98 rows=1 width=36) (actual time=0.001..0.001 rows=1 loops=102)
                    Cache Key: s.hall_id
                    Cache Mode: logical
                    Hits: 95  Misses: 7  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                    ->  Index Scan using hall_pk on hall h  (cost=0.15..4.97 rows=1 width=36) (actual time=0.002..0.002 rows=1 loops=7)
                            Index Cond: (id = s.hall_id)
    Planning Time: 0.325 ms
    Execution Time: 0.972 ms
    */

-- 3.2.2. План запроса на 100000+ строк

    /*
    Sort  (cost=3554.57..3555.82 rows=500 width=116) (actual time=61.232..61.965 rows=8835 loops=1)
        Sort Key: m.title, h.title, s.start_time
        Sort Method: quicksort  Memory: 1627kB
        ->  Nested Loop  (cost=0.32..3532.15 rows=500 width=116) (actual time=0.079..38.450 rows=8835 loops=1)
                ->  Nested Loop  (cost=0.15..3517.54 rows=500 width=88) (actual time=0.019..33.805 rows=8835 loops=1)
                    ->  Seq Scan on session s  (cost=0.00..3486.00 rows=500 width=20) (actual time=0.011..27.373 rows=8835 loops=1)
                            Filter: (((start_time) <= CURRENT_DATE) AND ((start_time) >= (CURRENT_DATE - '7 days'::interval)))
                            Rows Removed by Filter: 91165
                    ->  Memoize  (cost=0.15..0.20 rows=1 width=76) (actual time=0.000..0.000 rows=1 loops=8835)
                            Cache Key: s.movie_id
                            Cache Mode: logical
                            Hits: 8735  Misses: 100  Evictions: 0  Overflows: 0  Memory Usage: 18kB
                            ->  Index Scan using movie_pk on movie m  (cost=0.14..0.19 rows=1 width=76) (actual time=0.001..0.001 rows=1 loops=100)
                                Index Cond: (id = s.movie_id)
                ->  Memoize  (cost=0.16..0.28 rows=1 width=36) (actual time=0.000..0.000 rows=1 loops=8835)
                    Cache Key: s.hall_id
                    Cache Mode: logical
                    Hits: 8828  Misses: 7  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                    ->  Index Scan using hall_pk on hall h  (cost=0.15..0.27 rows=1 width=36) (actual time=0.009..0.009 rows=1 loops=7)
                            Index Cond: (id = s.hall_id)
    Planning Time: 0.255 ms
    Execution Time: 62.287 ms
    */

    CREATE INDEX session_start_time_idx ON public."session" (start_time);
    CREATE INDEX session_movie_id_idx ON public."session" (movie_id);
    CREATE INDEX session_hall_id_idx ON public."session" (hall_id);

-- 3.2.3. План запроса на 100000+ строк, после создания индекса

    /*
    Sort  (cost=1598.47..1617.74 rows=7711 width=116) (actual time=22.715..23.470 rows=7737 loops=1)
    Sort Key: m.title, h.title, s.start_time
    Sort Method: quicksort  Memory: 1281kB
    ->  Hash Join  (cost=149.71..1100.62 rows=7711 width=116) (actual time=0.379..6.574 rows=7737 loops=1)
            Hash Cond: (s.hall_id = h.id)
            ->  Hash Join  (cost=111.59..1042.18 rows=7711 width=88) (actual time=0.368..4.630 rows=7737 loops=1)
                Hash Cond: (s.movie_id = m.id)
                ->  Bitmap Heap Scan on session s  (cost=107.34..1016.84 rows=7711 width=20) (actual time=0.329..2.127 rows=7737 loops=1)
                        Recheck Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time <= CURRENT_DATE))
                        Heap Blocks: exact=736
                        ->  Bitmap Index Scan on session_start_time_idx  (cost=0.00..105.41 rows=7711 width=0) (actual time=0.262..0.263 rows=7737 loops=1)
                            Index Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time <= CURRENT_DATE))
                ->  Hash  (cost=3.00..3.00 rows=100 width=76) (actual time=0.035..0.036 rows=100 loops=1)
                        Buckets: 1024  Batches: 1  Memory Usage: 19kB
                        ->  Seq Scan on movie m  (cost=0.00..3.00 rows=100 width=76) (actual time=0.003..0.017 rows=100 loops=1)
            ->  Hash  (cost=22.50..22.50 rows=1250 width=36) (actual time=0.008..0.009 rows=7 loops=1)
                Buckets: 2048  Batches: 1  Memory Usage: 17kB
                ->  Seq Scan on hall h  (cost=0.00..22.50 rows=1250 width=36) (actual time=0.005..0.005 rows=7 loops=1)
    Planning Time: 0.263 ms
    Execution Time: 23.777 ms
    */

    DROP INDEX IF EXISTS session_start_time_idx;
    DROP INDEX IF EXISTS session_movie_id_idx;
    DROP INDEX IF EXISTS session_hall_id_idx;

-- 4. Поиск 3 самых прибыльных фильмов за неделю

    SELECT m.title, SUM(t.total)
    FROM public.ticket t 
    INNER JOIN public."session" s
        ON s.id = t.session_id
    INNER JOIN public.movie m
        ON m.id  = s.movie_id 
    WHERE s.start_time >= CURRENT_DATE - interval '7 days'
        AND s.start_time <= CURRENT_DATE
    GROUP BY m.title
    ORDER BY SUM(t.total) DESC
    LIMIT 3;

-- 4.1. План запроса на 100000+ строк

    /*
    Limit  (cost=1316.44..1316.45 rows=3 width=19) (actual time=17.079..17.082 rows=3 loops=1)
        ->  Sort  (cost=1316.44..1316.69 rows=100 width=19) (actual time=17.079..17.080 rows=3 loops=1)
                Sort Key: (sum(t.total)) DESC
                Sort Method: top-N heapsort  Memory: 25kB
                ->  HashAggregate  (cost=1314.15..1315.15 rows=100 width=19) (actual time=17.041..17.052 rows=61 loops=1)
                    Group Key: m.title
                    Batches: 1  Memory Usage: 24kB
                    ->  Nested Loop  (cost=13.07..1311.65 rows=500 width=19) (actual time=0.330..14.341 rows=10380 loops=1)
                            ->  Nested Loop  (cost=0.00..46.01 rows=5 width=19) (actual time=0.309..1.695 rows=102 loops=1)
                                Join Filter: (s.movie_id = m.id)
                                Rows Removed by Join Filter: 10098
                                ->  Seq Scan on movie m  (cost=0.00..3.00 rows=100 width=19) (actual time=0.004..0.031 rows=100 loops=1)
                                ->  Materialize  (cost=0.00..35.52 rows=5 width=8) (actual time=0.000..0.008 rows=102 loops=100)
                                        ->  Seq Scan on session s  (cost=0.00..35.50 rows=5 width=8) (actual time=0.006..0.253 rows=102 loops=1)
                                            Filter: (((start_time) <= CURRENT_DATE) AND ((start_time) >= (CURRENT_DATE - '7 days'::interval)))
                                            Rows Removed by Filter: 898
                            ->  Bitmap Heap Scan on ticket t  (cost=13.07..252.13 rows=100 width=8) (actual time=0.017..0.104 rows=102 loops=102)
                                Recheck Cond: (session_id = s.id)
                                Heap Blocks: exact=9782
                                ->  Bitmap Index Scan on ticket_un  (cost=0.00..13.04 rows=100 width=0) (actual time=0.008..0.008 rows=102 loops=102)
                                        Index Cond: (session_id = s.id)
    Planning Time: 0.335 ms
    Execution Time: 17.117 ms
    */

-- 4.2. План запроса на 10000000+ строк

    /*
    Limit  (cost=142541.84..142541.85 rows=3 width=19) (actual time=1281.456..1283.910 rows=3 loops=1)
        ->  Sort  (cost=142541.84..142542.09 rows=100 width=19) (actual time=1267.188..1269.640 rows=3 loops=1)
                Sort Key: (sum(t.total)) DESC
                Sort Method: top-N heapsort  Memory: 25kB
                ->  Finalize GroupAggregate  (cost=142515.21..142540.55 rows=100 width=19) (actual time=1266.948..1269.605 rows=100 loops=1)
                    Group Key: m.title
                    ->  Gather Merge  (cost=142515.21..142538.55 rows=200 width=19) (actual time=1266.939..1269.505 rows=300 loops=1)
                            Workers Planned: 2
                            Workers Launched: 2
                            ->  Sort  (cost=141515.19..141515.44 rows=100 width=19) (actual time=1236.368..1236.376 rows=100 loops=3)
                                Sort Key: m.title
                                Sort Method: quicksort  Memory: 31kB
                                Worker 0:  Sort Method: quicksort  Memory: 31kB
                                Worker 1:  Sort Method: quicksort  Memory: 31kB
                                ->  Partial HashAggregate  (cost=141510.87..141511.87 rows=100 width=19) (actual time=1236.230..1236.248 rows=100 loops=3)
                                        Group Key: m.title
                                        Batches: 1  Memory Usage: 32kB
                                        Worker 0:  Batches: 1  Memory Usage: 40kB
                                        Worker 1:  Batches: 1  Memory Usage: 40kB
                                        ->  Hash Join  (cost=3086.64..139904.41 rows=321292 width=19) (actual time=32.567..1150.370 rows=259260 loops=3)
                                            Hash Cond: (s.movie_id = m.id)
                                            ->  Hash Join  (cost=3082.39..139021.02 rows=321292 width=8) (actual time=22.490..1065.131 rows=259260 loops=3)
                                                    Hash Cond: (t.session_id = s.id)
                                                    ->  Parallel Seq Scan on ticket t  (cost=0.00..125000.67 rows=4166667 width=8) (actual time=0.032..346.787 rows=3333333 loops=3)
                                                    ->  Hash  (cost=2986.00..2986.00 rows=7711 width=8) (actual time=22.431..22.431 rows=7737 loops=3)
                                                        Buckets: 8192  Batches: 1  Memory Usage: 367kB
                                                        ->  Seq Scan on session s  (cost=0.00..2986.00 rows=7711 width=8) (actual time=0.025..20.224 rows=7737 loops=3)
                                                                Filter: ((start_time <= CURRENT_DATE) AND (start_time >= (CURRENT_DATE - '7 days'::interval)))
                                                                Rows Removed by Filter: 92263
                                            ->  Hash  (cost=3.00..3.00 rows=100 width=19) (actual time=10.057..10.057 rows=100 loops=3)
                                                    Buckets: 1024  Batches: 1  Memory Usage: 14kB
                                                    ->  Seq Scan on movie m  (cost=0.00..3.00 rows=100 width=19) (actual time=10.003..10.023 rows=100 loops=3)
    Planning Time: 0.452 ms
        JIT:
        Functions: 82
        Options: Inlining false, Optimization false, Expressions true, Deforming true
        Timing: Generation 6.690 ms, Inlining 0.000 ms, Optimization 1.944 ms, Emission 41.408 ms, Total 50.041 ms
    Execution Time: 1286.161 ms
    */

    CREATE INDEX session_start_time_idx ON public."session" (start_time);
    CREATE INDEX ticket_session_id_idx ON public.ticket (session_id);

-- 4.3. План запроса на 10000000+ строк, после создания индекса

    /*
    Limit  (cost=140572.68..140572.68 rows=3 width=19) (actual time=1244.186..1246.418 rows=3 loops=1)
        ->  Sort  (cost=140572.68..140572.93 rows=100 width=19) (actual time=1228.939..1231.170 rows=3 loops=1)
                Sort Key: (sum(t.total)) DESC
                Sort Method: top-N heapsort  Memory: 25kB
                ->  Finalize GroupAggregate  (cost=140546.05..140571.38 rows=100 width=19) (actual time=1228.716..1231.138 rows=100 loops=1)
                    Group Key: m.title
                    ->  Gather Merge  (cost=140546.05..140569.38 rows=200 width=19) (actual time=1228.693..1231.048 rows=300 loops=1)
                            Workers Planned: 2
                            Workers Launched: 2
                            ->  Sort  (cost=139546.03..139546.28 rows=100 width=19) (actual time=1198.476..1198.485 rows=100 loops=3)
                                Sort Key: m.title
                                Sort Method: quicksort  Memory: 31kB
                                Worker 0:  Sort Method: quicksort  Memory: 31kB
                                Worker 1:  Sort Method: quicksort  Memory: 31kB
                                ->  Partial HashAggregate  (cost=139541.70..139542.70 rows=100 width=19) (actual time=1198.337..1198.355 rows=100 loops=3)
                                        Group Key: m.title
                                        Batches: 1  Memory Usage: 32kB
                                        Worker 0:  Batches: 1  Memory Usage: 40kB
                                        Worker 1:  Batches: 1  Memory Usage: 40kB
                                        ->  Hash Join  (cost=1117.47..137935.24 rows=321292 width=19) (actual time=15.370..1115.018 rows=259260 loops=3)
                                            Hash Cond: (s.movie_id = m.id)
                                            ->  Hash Join  (cost=1113.22..137051.86 rows=321292 width=8) (actual time=4.650..1029.133 rows=259260 loops=3)
                                                    Hash Cond: (t.session_id = s.id)
                                                    ->  Parallel Seq Scan on ticket t  (cost=0.00..125000.67 rows=4166667 width=8) (actual time=0.023..339.579 rows=3333333 loops=3)
                                                    ->  Hash  (cost=1016.84..1016.84 rows=7711 width=8) (actual time=4.601..4.602 rows=7737 loops=3)
                                                        Buckets: 8192  Batches: 1  Memory Usage: 367kB
                                                        ->  Bitmap Heap Scan on session s  (cost=107.34..1016.84 rows=7711 width=8) (actual time=0.394..3.024 rows=7737 loops=3)
                                                                Recheck Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time <= CURRENT_DATE))
                                                                Heap Blocks: exact=736
                                                                ->  Bitmap Index Scan on session_start_time_idx  (cost=0.00..105.41 rows=7711 width=0) (actual time=0.309..0.310 rows=7737 loops=3)
                                                                    Index Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time <= CURRENT_DATE))
                                            ->  Hash  (cost=3.00..3.00 rows=100 width=19) (actual time=10.701..10.702 rows=100 loops=3)
                                                    Buckets: 1024  Batches: 1  Memory Usage: 14kB
                                                    ->  Seq Scan on movie m  (cost=0.00..3.00 rows=100 width=19) (actual time=10.661..10.677 rows=100 loops=3)
    Planning Time: 0.699 ms
        JIT:
        Functions: 88
        Options: Inlining false, Optimization false, Expressions true, Deforming true
        Timing: Generation 8.827 ms, Inlining 0.000 ms, Optimization 2.567 ms, Emission 43.845 ms, Total 55.239 ms
    Execution Time: 1251.353 ms
    */

    DROP INDEX IF EXISTS session_start_time_idx;
    DROP INDEX IF EXISTS ticket_session_id_idx;

-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

    SELECT 
        hs."row_number", 
        hs.seat_number,
        CASE WHEN t.id IS NOT NULL
            THEN 1
            ELSE 0
        END AS is_occupied
    FROM public."session" s 
    INNER JOIN hall_scheme hs 
        ON hs.hall_id = s.hall_id 
    LEFT JOIN public.ticket t 
        ON t.session_id = s.id 
        AND t.hall_scheme_id = hs.id 
    WHERE s.id = 500
    ORDER BY hs."row_number", hs.seat_number;

-- 5.1. План запроса на 100000+ строк

    /*
    Sort  (cost=400.08..401.83 rows=700 width=8) (actual time=0.994..1.047 rows=700 loops=1)
        Sort Key: hs.row_number, hs.seat_number
        Sort Method: quicksort  Memory: 57kB
        ->  Hash Left Join  (cost=312.56..367.00 rows=700 width=8) (actual time=0.340..0.835 rows=700 loops=1)
                Hash Cond: ((s.id = t.session_id) AND (hs.id = t.hall_scheme_id))
                ->  Nested Loop  (cost=17.98..68.75 rows=700 width=12) (actual time=0.069..0.340 rows=700 loops=1)
                    ->  Index Scan using session_pk on session s  (cost=0.28..8.29 rows=1 width=8) (actual time=0.009..0.013 rows=1 loops=1)
                            Index Cond: (id = 500)
                    ->  Bitmap Heap Scan on hall_scheme hs  (cost=17.71..53.46 rows=700 width=12) (actual time=0.055..0.160 rows=700 loops=1)
                            Recheck Cond: (hall_id = s.hall_id)
                            Heap Blocks: exact=5
                            ->  Bitmap Index Scan on hall_scheme_unq_idx  (cost=0.00..17.53 rows=700 width=0) (actual time=0.045..0.045 rows=700 loops=1)
                                Index Cond: (hall_id = s.hall_id)
                ->  Hash  (cost=293.11..293.11 rows=98 width=12) (actual time=0.263..0.264 rows=108 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 13kB
                    ->  Bitmap Heap Scan on ticket t  (cost=13.05..293.11 rows=98 width=12) (actual time=0.028..0.222 rows=108 loops=1)
                            Recheck Cond: (session_id = 500)
                            Heap Blocks: exact=102
                            ->  Bitmap Index Scan on ticket_un  (cost=0.00..13.03 rows=98 width=0) (actual time=0.012..0.012 rows=108 loops=1)
                                Index Cond: (session_id = 500)
    Planning Time: 0.338 ms
    Execution Time: 1.145 ms
    */

-- 5.2. План запроса на 10000000+ строк

    /*
    Sort  (cost=514.72..516.47 rows=700 width=8) (actual time=3.267..3.307 rows=700 loops=1)
    Sort Key: hs.row_number, hs.seat_number
    Sort Method: quicksort  Memory: 57kB
    ->  Hash Left Join  (cost=427.20..481.64 rows=700 width=8) (actual time=2.816..3.162 rows=700 loops=1)
            Hash Cond: ((s.id = t.session_id) AND (hs.id = t.hall_scheme_id))
            ->  Nested Loop  (cost=18.00..68.77 rows=700 width=12) (actual time=0.137..0.329 rows=700 loops=1)
                ->  Index Scan using session_pk on session s  (cost=0.29..8.31 rows=1 width=8) (actual time=0.011..0.014 rows=1 loops=1)
                        Index Cond: (id = 500)
                ->  Bitmap Heap Scan on hall_scheme hs  (cost=17.71..53.46 rows=700 width=12) (actual time=0.121..0.195 rows=700 loops=1)
                        Recheck Cond: (hall_id = s.hall_id)
                        Heap Blocks: exact=5
                        ->  Bitmap Index Scan on hall_scheme_unq_idx  (cost=0.00..17.53 rows=700 width=0) (actual time=0.109..0.109 rows=700 loops=1)
                            Index Cond: (hall_id = s.hall_id)
            ->  Hash  (cost=407.66..407.66 rows=103 width=12) (actual time=2.670..2.671 rows=198 loops=1)
                Buckets: 1024  Batches: 1  Memory Usage: 17kB
                ->  Bitmap Heap Scan on ticket t  (cost=5.23..407.66 rows=103 width=12) (actual time=0.075..2.559 rows=198 loops=1)
                        Recheck Cond: (session_id = 500)
                        Heap Blocks: exact=192
                        ->  Bitmap Index Scan on ticket_un  (cost=0.00..5.21 rows=103 width=0) (actual time=0.038..0.038 rows=198 loops=1)
                            Index Cond: (session_id = 500)
    Planning Time: 0.386 ms
    Execution Time: 3.399 ms
    */

    CREATE INDEX hall_scheme_hall_id_idx ON public.hall_scheme (hall_id);

-- 5.3. План запроса на 10000000+ строк, после создания индекса

    /*
    Sort  (cost=514.72..516.47 rows=700 width=8) (actual time=1.164..1.209 rows=700 loops=1)
    Sort Key: hs.row_number, hs.seat_number
    Sort Method: quicksort  Memory: 57kB
    ->  Hash Left Join  (cost=427.20..481.64 rows=700 width=8) (actual time=0.416..1.001 rows=700 loops=1)
            Hash Cond: ((s.id = t.session_id) AND (hs.id = t.hall_scheme_id))
            ->  Nested Loop  (cost=18.00..68.77 rows=700 width=12) (actual time=0.056..0.409 rows=700 loops=1)
                ->  Index Scan using session_pk on session s  (cost=0.29..8.31 rows=1 width=8) (actual time=0.010..0.013 rows=1 loops=1)
                        Index Cond: (id = 500)
                ->  Bitmap Heap Scan on hall_scheme hs  (cost=17.71..53.46 rows=700 width=12) (actual time=0.042..0.141 rows=700 loops=1)
                        Recheck Cond: (hall_id = s.hall_id)
                        Heap Blocks: exact=5
                        ->  Bitmap Index Scan on hall_scheme_unq_idx  (cost=0.00..17.53 rows=700 width=0) (actual time=0.035..0.035 rows=700 loops=1)
                            Index Cond: (hall_id = s.hall_id)
            ->  Hash  (cost=407.66..407.66 rows=103 width=12) (actual time=0.353..0.354 rows=198 loops=1)
                Buckets: 1024  Batches: 1  Memory Usage: 17kB
                ->  Bitmap Heap Scan on ticket t  (cost=5.23..407.66 rows=103 width=12) (actual time=0.042..0.290 rows=198 loops=1)
                        Recheck Cond: (session_id = 500)
                        Heap Blocks: exact=192
                        ->  Bitmap Index Scan on ticket_un  (cost=0.00..5.21 rows=103 width=0) (actual time=0.019..0.019 rows=198 loops=1)
                            Index Cond: (session_id = 500)
    Planning Time: 0.478 ms
    Execution Time: 1.359 ms
    */

    DROP INDEX IF EXISTS hall_scheme_hall_id_idx;

-- 6. Вывести диапазон миниальной и максимальной цены за билет на фильмы этой недели

    SELECT m.title, MIN(s.price) AS min_price, MAX(s.price) AS max_price
    FROM public."session" s 
    INNER JOIN public.movie m
        ON m.id  = s.movie_id 
    WHERE s.start_time >= CURRENT_DATE - interval '7 days'
        AND s.start_time <= CURRENT_DATE
    GROUP BY m.title
    ORDER BY m.title;

-- 6.1. План запроса на 10000+ строк

    /*
    Sort  (cost=60.52..60.62 rows=5 width=23) (actual time=0.588..0.629 rows=61 loops=1)
        Sort Key: m.title
        Sort Method: quicksort  Memory: 31kB
        ->  HashAggregate  (cost=60.52..60.53 rows=5 width=19) (actual time=0.583..0.589 rows=102 loops=1)
                Group Key: m.title
                Batches: 1  Memory Usage: 32kB
                ->  Hash Join  (cost=39.81..60.46 rows=5 width=19) (actual time=0.312..0.512 rows=102 loops=1)
                    Hash Cond: (s.movie_id = m.id)
                    ->  Seq Scan on session s   (cost=0.00..35.50 rows=5 width=8) (actual time=0.005..0.252 rows=102 loops=1)
                            Filter: ((start_time <= CURRENT_DATE) AND (start_time >= (CURRENT_DATE - '7 days'::interval)))
                            Rows Removed by Filter: 898
                    ->  Hash  (cost=3.00..3.00 rows=100 width=19) (actual time=0.059..0.060 rows=100 loops=1)
                            Buckets: 1024  Batches: 1  Memory Usage: 14kB
                            ->  Seq Scan on movie m  (cost=0.00..3.00 rows=100 width=19) (actual time=0.005..0.029 rows=100 loops=1)
    Planning Time: 0.345 ms
    Execution Time: 0.657 ms
    */

-- 6.2. План запроса на 100000+ строк

    /*
    Sort  (cost=3073.50..3073.75 rows=100 width=23) (actual time=23.874..23.884 rows=100 loops=1)
        Sort Key: m.title
        Sort Method: quicksort  Memory: 31kB
        ->  HashAggregate  (cost=3069.18..3070.18 rows=100 width=23) (actual time=23.746..23.766 rows=100 loops=1)
                Group Key: m.title
                Batches: 1  Memory Usage: 32kB
                ->  Hash Join  (cost=4.25..3011.35 rows=7711 width=19) (actual time=0.074..21.003 rows=7737 loops=1)
                    Hash Cond: (s.movie_id = m.id)
                    ->  Seq Scan on session s  (cost=0.00..2986.00 rows=7711 width=8) (actual time=0.010..18.363 rows=7737 loops=1)
                            Filter: ((start_time <= CURRENT_DATE) AND (start_time >= (CURRENT_DATE - '7 days'::interval)))
                            Rows Removed by Filter: 92263
                    ->  Hash  (cost=3.00..3.00 rows=100 width=19) (actual time=0.059..0.060 rows=100 loops=1)
                            Buckets: 1024  Batches: 1  Memory Usage: 14kB
                            ->  Seq Scan on movie m  (cost=0.00..3.00 rows=100 width=19) (actual time=0.005..0.029 rows=100 loops=1)
        Planning Time: 0.283 ms
        Execution Time: 23.931 ms
    */

    CREATE INDEX session_movie_id_idx ON public."session" (movie_id);
    CREATE INDEX session_start_time_idx ON public."session" (start_time);

-- 6.2. План запроса на 100000+ строк, после создания индекса

    /*
    Sort  (cost=1104.34..1104.59 rows=100 width=23) (actual time=9.966..9.976 rows=100 loops=1)
        Sort Key: m.title
        Sort Method: quicksort  Memory: 31kB
        ->  HashAggregate  (cost=1100.02..1101.02 rows=100 width=23) (actual time=9.822..9.848 rows=100 loops=1)
                Group Key: m.title
                Batches: 1  Memory Usage: 32kB
                ->  Hash Join  (cost=111.59..1042.18 rows=7711 width=19) (actual time=0.474..6.579 rows=7737 loops=1)
                    Hash Cond: (s.movie_id = m.id)
                    ->  Bitmap Heap Scan on session s  (cost=107.34..1016.84 rows=7711 width=8) (actual time=0.421..3.005 rows=7737 loops=1)
                            Recheck Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time <= CURRENT_DATE))
                            Heap Blocks: exact=736
                            ->  Bitmap Index Scan on session_start_time_idx  (cost=0.00..105.41 rows=7711 width=0) (actual time=0.333..0.333 rows=7737 loops=1)
                                Index Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time <= CURRENT_DATE))
                    ->  Hash  (cost=3.00..3.00 rows=100 width=19) (actual time=0.046..0.047 rows=100 loops=1)
                            Buckets: 1024  Batches: 1  Memory Usage: 14kB
                            ->  Seq Scan on movie m  (cost=0.00..3.00 rows=100 width=19) (actual time=0.006..0.023 rows=100 loops=1)
    Planning Time: 0.247 ms
    Execution Time: 10.028 ms
    */

    DROP INDEX IF EXISTS session_movie_id_idx;
    DROP INDEX IF EXISTS session_start_time_idx;