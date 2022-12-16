CREATE TABLE "MovieAttributeValue"
(
    "id"             int NOT NULL,
    "Movie"          int NOT NULL,
    "MovieAttribute" int NOT NULL,
    "ValueId"        int NOT NULL,
    CONSTRAINT "pk_MovieAttributeValue" PRIMARY KEY (
                                                     "id"
        )
);

CREATE TABLE "MovieAttributeType"
(
    "id"   int     NOT NULL,
    "Type" varchar NOT NULL,
    CONSTRAINT "pk_MovieAttributeType" PRIMARY KEY (
                                                    "id"
        )
);

CREATE TABLE "MovieAttribute"
(
    "id"                 int     NOT NULL,
    "MovieAttributeType" int     NOT NULL,
    "Name"               varchar NOT NULL,
    CONSTRAINT "pk_MovieAttribute" PRIMARY KEY (
                                                "id"
        )
);

CREATE TABLE "AttributeValueText"
(
    "id"    int  NOT NULL,
    "Value" text NOT NULL,
    CONSTRAINT "pk_AttributeValueText" PRIMARY KEY (
                                                    "id"
        )
);

CREATE TABLE "AttributeValueBool"
(
    "id"    int     NOT NULL,
    "Value" boolean NOT NULL,
    CONSTRAINT "pk_AttributeValueBool" PRIMARY KEY (
                                                    "id"
        )
);

CREATE TABLE "AttributeValueDate"
(
    "id"    int  NOT NULL,
    "Value" date NOT NULL,
    CONSTRAINT "pk_AttributeValueDate" PRIMARY KEY (
                                                    "id"
        )
);

ALTER TABLE "MovieAttributeValue"
    ADD CONSTRAINT "fk_MovieAttributeValue_Movie" FOREIGN KEY ("Movie")
        REFERENCES "Movie" ("id");

ALTER TABLE "MovieAttributeValue"
    ADD CONSTRAINT "fk_MovieAttributeValue_MovieAttribute" FOREIGN KEY ("MovieAttribute")
        REFERENCES "MovieAttribute" ("id");

ALTER TABLE "MovieAttribute"
    ADD CONSTRAINT "fk_MovieAttribute_MovieAttributeType" FOREIGN KEY ("MovieAttributeType")
        REFERENCES "MovieAttributeType" ("id");
