CREATE TABLE "move"
(
    "id"   serial       NOT NULL,
    "name" varchar(200) NOT NULL,
    CONSTRAINT "move_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

CREATE TABLE "move_atrribute"
(
    "id"                     serial       NOT NULL,
    "move_attribute_type_id" bigint       NOT NULL,
    "name"                   varchar(255) NOT NULL UNIQUE,
    CONSTRAINT "move_atrribute_pk" PRIMARY KEY ("id")
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
    "id"                serial       NOT NULL,
    "move_id"           bigint       NOT NULL,
    "move_attribute_id" bigint       NOT NULL,
    "value_bigint"      bigint       NOT NULL,
    "value_string"      varchar(255) NOT NULL,
    "value_text"        TEXT         NOT NULL,
    "value_date"        DATE         NOT NULL,
    "value_time"        TIME         NOT NULL,
    "value_decimal"     DECIMAL      NOT NULL,
    CONSTRAINT "move_value_pk" PRIMARY KEY ("id")
) WITH (
OIDS = FALSE
);

ALTER TABLE "move_atrribute"
    ADD CONSTRAINT "move_atrribute_fk0" FOREIGN KEY ("move_attribute_type_id") REFERENCES "move_attribute_type" ("id");

ALTER TABLE "move_value"
    ADD CONSTRAINT "move_value_fk0" FOREIGN KEY ("move_id") REFERENCES "move" ("id");
ALTER TABLE "move_value"
    ADD CONSTRAINT "move_value_fk1" FOREIGN KEY ("move_attribute_id") REFERENCES "move_atrribute" ("id");
