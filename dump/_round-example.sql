/* округление */
SELECT x,
  round(x::numeric) AS "numeric",
  round(x::double precision) AS "double"
FROM generate_series(-3.5, 3.5, 1) as x;