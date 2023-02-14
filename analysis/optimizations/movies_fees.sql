CREATE TABLE "MovieFees"
(
    "id"       SERIAL PRIMARY KEY,
    "Movie"    int  NOT NULL,
    "Fees"     int  NOT NULL DEFAULT 0,
    "Schedule" int  NOT NULL,
    "Date"     date NOT NULL
);

ALTER TABLE "MovieFees"
    ADD CONSTRAINT "fk_MovieFees_Movie" FOREIGN KEY ("Movie")
        REFERENCES "Movie" ("id");

ALTER TABLE "MovieFees"
    ADD CONSTRAINT "fk_MovieFees_Schedule" FOREIGN KEY ("Schedule")
        REFERENCES "Schedule" ("id");

TRUNCATE TABLE "MovieFees";

DROP TABLE "MovieFees";

-- Init values for MovieFees table

INSERT INTO "MovieFees" ("Movie", "Fees", "Date", "Schedule")
SELECT M.id, t_sum.sum, Sch."Date", Sch."id"
FROM "Schedule" AS Sch
         INNER JOIN "Movie" M on M.id = Sch."Movie",
     (SELECT "Schedule", SUM("Price") as sum
      FROM "Ticket"
      GROUP BY "Schedule") as t_sum
WHERE Sch.id = t_sum."Schedule"
ORDER BY Sch."Date" DESC;

-- Create trigger for updating MovieFees table

CREATE OR REPLACE FUNCTION update_movie_fees() RETURNS TRIGGER AS
$movie_fees$
BEGIN
    IF (TG_OP = 'DELETE') THEN
        UPDATE "MovieFees" SET "Fees" = "Fees" - OLD."Price" WHERE "MovieFees"."Schedule" = OLD."Schedule";
    ELSIF (TG_OP = 'UPDATE') THEN
        UPDATE "MovieFees"
        SET "Fees" = "Fees" - OLD."Price" + NEW."Price"
        WHERE "MovieFees"."Schedule" = OLD."Schedule";
    ELSIF (TG_OP = 'INSERT') THEN
        IF EXISTS(SELECT "Schedule" FROM "MovieFees" WHERE "MovieFees"."Schedule" = NEW."Schedule")
        THEN
            UPDATE "MovieFees" SET "Fees" = "Fees" + NEW."Price" WHERE "MovieFees"."Schedule" = NEW."Schedule";
        ELSE
            INSERT INTO "MovieFees" ("Movie", "Fees", "Date", "Schedule")
            SELECT M.id, NEW."Price", Sch."Date", Sch."id"
            FROM "Schedule" AS Sch
                     INNER JOIN "Movie" M on M.id = Sch."Movie"
            WHERE Sch.id = NEW."Schedule";
        END IF;
    END IF;
    RETURN NULL;
END;
$movie_fees$ LANGUAGE plpgsql;

CREATE TRIGGER movie_fees
    AFTER INSERT OR UPDATE OR DELETE
    ON "Ticket"
    FOR EACH ROW
EXECUTE FUNCTION update_movie_fees();


-- NEW SQL FOR 3_most_profitable_movies
EXPLAIN ANALYSE
SELECT M."Name", SUM(MF."Fees") as sum
FROM "MovieFees" AS MF
         INNER JOIN "Movie" M on M.id = MF."Movie"
GROUP BY M."Name"
ORDER BY sum DESC
LIMIT 3;