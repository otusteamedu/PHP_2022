CREATE TABLE "TicketsSales"
(
    "id"    SERIAL PRIMARY KEY,
    "Sales" int  NOT NULL DEFAULT 0,
    "Date"  date NOT NULL
);

TRUNCATE TABLE "TicketsSales";

DROP TABLE "TicketsSales";

-- Init values for TicketsSales table

INSERT INTO "TicketsSales" ("Sales", "Date")
SELECT SUM("Price") as sum, date_trunc('day', "PurchaseTime") as date
FROM "Ticket"
GROUP BY date_trunc('day', "PurchaseTime")
ORDER BY date DESC;

CREATE INDEX IF NOT EXISTS idx_tickets_sales_date ON "TicketsSales" ("Date");

-- Create trigger for updating TicketsSales table

CREATE OR REPLACE FUNCTION update_tickets_sales() RETURNS TRIGGER AS
$tickets_sales$
BEGIN
    IF (TG_OP = 'DELETE') THEN
        UPDATE "TicketsSales"
        SET "Sales" = "Sales" - OLD."Price"
        WHERE "TicketsSales"."Date" = date_trunc('day', OLD."PurchaseTime");
    ELSIF (TG_OP = 'UPDATE') THEN
        UPDATE "TicketsSales"
        SET "Sales" = "Sales" - OLD."Price" + NEW."Price"
        WHERE "TicketsSales"."Date" = date_trunc('day', OLD."PurchaseTime");
    ELSIF (TG_OP = 'INSERT') THEN
        IF EXISTS(SELECT "Date" FROM "TicketsSales" WHERE "TicketsSales"."Date" = date_trunc('day', NEW."PurchaseTime"))
        THEN
            UPDATE "TicketsSales"
            SET "Sales" = "Sales" + NEW."Price"
            WHERE "TicketsSales"."Date" = date_trunc('day', NEW."PurchaseTime");
        ELSE
            INSERT INTO "TicketsSales" ("Sales", "Date") VALUES (NEW."Price", date_trunc('day', NEW."PurchaseTime"));
        END IF;
    END IF;
    RETURN NULL;
END;
$tickets_sales$ LANGUAGE plpgsql;

CREATE TRIGGER tickets_sales
    AFTER INSERT OR UPDATE OR DELETE
    ON "Ticket"
    FOR EACH ROW
EXECUTE FUNCTION update_tickets_sales();

-- NEW SQL FOR tickets_by_week
EXPLAIN ANALYSE
SELECT SUM("Sales")
FROM "TicketsSales"
WHERE "TicketsSales"."Date" <= CURRENT_DATE
  AND "TicketsSales"."Date" >= CURRENT_DATE - 7;