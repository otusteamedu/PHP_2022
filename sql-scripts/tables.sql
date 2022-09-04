CREATE TABLE "attributes" (
	"uid" BIGINT NOT NULL DEFAULT 'nextval(''attributes_uid_seq''::regclass)',
	"attribute_name" VARCHAR NOT NULL,
	"attribute_type_id" BIGINT NOT NULL,
	PRIMARY KEY ("uid"),
	CONSTRAINT "FK_attributes_attribute_types" FOREIGN KEY ("attribute_type_id") REFERENCES "attribute_types" ("uid") ON UPDATE NO ACTION ON DELETE NO ACTION
)
;
COMMENT ON COLUMN "attributes"."uid" IS '';
COMMENT ON COLUMN "attributes"."attribute_name" IS '';
COMMENT ON COLUMN "attributes"."attribute_type_id" IS '';


CREATE TABLE "attribute_types" (
	"uid" BIGINT NOT NULL DEFAULT 'nextval(''attribute_types_uid_seq''::regclass)',
	"attribute_type_name" VARCHAR NOT NULL,
	PRIMARY KEY ("uid")
)
;
COMMENT ON COLUMN "attribute_types"."uid" IS '';
COMMENT ON COLUMN "attribute_types"."attribute_type_name" IS '';

CREATE TABLE "attribute_values" (
	"uid" BIGINT NOT NULL DEFAULT 'nextval(''attribute_values_uid_seq''::regclass)',
	"film_id" BIGINT NOT NULL,
	"attribute_id" BIGINT NOT NULL,
	"value_varchar" VARCHAR(255) NULL DEFAULT NULL,
	"value_text" TEXT NULL DEFAULT NULL,
	"value_date" DATE NULL DEFAULT NULL,
	"value_numeric" NUMERIC(18,2) NULL DEFAULT NULL,
	"value_integer" INTEGER NULL DEFAULT NULL,
	"value_boolean" BOOLEAN NULL DEFAULT NULL,
	PRIMARY KEY ("uid"),
	CONSTRAINT "FK_attribute_values_attributes" FOREIGN KEY ("attribute_id") REFERENCES "attributes" ("uid") ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT "FK_attribute_values_films" FOREIGN KEY ("film_id") REFERENCES "films" ("uid") ON UPDATE NO ACTION ON DELETE NO ACTION
)
;
COMMENT ON COLUMN "attribute_values"."uid" IS '';
COMMENT ON COLUMN "attribute_values"."film_id" IS '';
COMMENT ON COLUMN "attribute_values"."attribute_id" IS '';
COMMENT ON COLUMN "attribute_values"."value_varchar" IS '';
COMMENT ON COLUMN "attribute_values"."value_text" IS '';
COMMENT ON COLUMN "attribute_values"."value_date" IS '';
COMMENT ON COLUMN "attribute_values"."value_numeric" IS '';
COMMENT ON COLUMN "attribute_values"."value_integer" IS '';
COMMENT ON COLUMN "attribute_values"."value_boolean" IS '';


CREATE TABLE "films" (
	"uid" BIGINT NOT NULL DEFAULT 'nextval(''films_uid_seq''::regclass)',
	"film_name" VARCHAR NOT NULL,
	"year" VARCHAR(4) NOT NULL,
	"age_category" VARCHAR(3) NOT NULL,
	PRIMARY KEY ("uid")
)
;
COMMENT ON COLUMN "films"."uid" IS '';
COMMENT ON COLUMN "films"."film_name" IS '';
COMMENT ON COLUMN "films"."year" IS '';
COMMENT ON COLUMN "films"."age_category" IS '';
