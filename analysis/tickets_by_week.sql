EXPLAIN ANALYSE
SELECT SUM("Price")
FROM "Ticket"
WHERE "Ticket"."PurchaseTime" <= CURRENT_DATE
  AND "Ticket"."PurchaseTime" >= CURRENT_DATE - 7;