CREATE TABLE "public.Films" (
	"id" serial NOT NULL,
	"name" varchar(500) NOT NULL,
	"active" BOOLEAN NOT NULL,
	CONSTRAINT "Films_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);



CREATE TABLE "public.Attributes" (
	"id" serial NOT NULL,
	"name" varchar(500) NOT NULL,
	"film_id" integer NOT NULL,
	CONSTRAINT "Attributes_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);



CREATE TABLE "public.AttributeTypes" (
	"id" serial NOT NULL,
	"name" varchar(255) NOT NULL UNIQUE,
	"value_type" varchar(255) NOT NULL,
	CONSTRAINT "AttributeTypes_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);



CREATE TABLE "public.Values" (
	"id" serial NOT NULL,
	"value_integer" integer NOT NULL,
	"value_text" TEXT NOT NULL,
	"value_boolean" BOOLEAN NOT NULL,
	"value_float" FLOAT NOT NULL,
	"value_date" DATE NOT NULL,
	"attribute_id" integer NOT NULL,
	CONSTRAINT "Values_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);




ALTER TABLE "Attributes" ADD CONSTRAINT "Attributes_fk0" FOREIGN KEY ("film_id") REFERENCES "Films"("id");

ALTER TABLE "AttributeTypes" ADD CONSTRAINT "AttributeTypes_fk0" FOREIGN KEY ("name") REFERENCES "Attributes"("id");

ALTER TABLE "Values" ADD CONSTRAINT "Values_fk0" FOREIGN KEY ("attribute_id") REFERENCES "Attributes"("id");





