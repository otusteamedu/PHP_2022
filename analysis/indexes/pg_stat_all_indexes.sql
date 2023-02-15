SELECT *
FROM pg_stat_all_indexes
WHERE schemaname = 'public' ORDER BY idx_scan DESC LIMIT 5;

SELECT *
FROM pg_stat_all_indexes
WHERE schemaname = 'public' ORDER BY idx_scan LIMIT 5;