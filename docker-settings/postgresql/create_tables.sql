CREATE TABLE "move_entity"
(
    "id"   serial       NOT NULL,
    "name" varchar(255) NOT NULL,
    CONSTRAINT "move_entity_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

CREATE TABLE "move_attribute"
(
    "id"                     serial       NOT NULL,
    "move_attribute_type_id" bigint       NOT NULL,
    "name"                   varchar(255) NOT NULL UNIQUE,
    CONSTRAINT "move_attribute_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

CREATE TABLE "move_attribute_type"
(
    "id"   serial       NOT NULL,
    "name" varchar(220) NOT NULL UNIQUE,
    CONSTRAINT "move_attribute_type_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

CREATE TABLE "move_value"
(
    "id"                serial NOT NULL,
    "move_entity_id"    bigint NOT NULL,
    "move_attribute_id" bigint NOT NULL,
    "value_int"         integer,
    "value_string"      varchar(255),
    "value_text"        TEXT,
    "value_jsonb"       jsonb,
    "value_timestamp"   TIMESTAMP,
    "value_decimal"     DECIMAL,
    CONSTRAINT "move_value_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

ALTER TABLE "move_attribute"
    ADD CONSTRAINT "move_attribute_fk0" FOREIGN KEY ("move_attribute_type_id") REFERENCES "move_attribute_type" ("id");

ALTER TABLE "move_value"
    ADD CONSTRAINT "move_value_fk0" FOREIGN KEY ("move_entity_id") REFERENCES "move_entity" ("id");
ALTER TABLE "move_value"
    ADD CONSTRAINT "move_value_fk1" FOREIGN KEY ("move_attribute_id") REFERENCES "move_attribute" ("id");
