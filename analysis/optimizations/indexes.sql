CREATE INDEX IF NOT EXISTS idx_tickets_schedules ON "Ticket" ("Schedule");
DROP INDEX IF EXISTS idx_tickets_schedules;

CREATE INDEX IF NOT EXISTS idx_schedule_date ON "Schedule" ("Date");
DROP INDEX IF EXISTS idx_schedule_date;

CREATE INDEX IF NOT EXISTS idx_tickets_purchase_time ON "Ticket" ("PurchaseTime");
DROP INDEX IF EXISTS idx_tickets_purchase_time;

ANALYSE;