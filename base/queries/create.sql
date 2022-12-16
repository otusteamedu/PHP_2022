CREATE TABLE "Cinema"
(
    "id"      int     NOT NULL,
    "Name"    varchar NOT NULL,
    "Address" int     NOT NULL,
    CONSTRAINT "pk_Cinema" PRIMARY KEY (
                                        "id"
        )
);

CREATE TABLE "Address"
(
    "id"       int     NOT NULL,
    "City"     varchar NOT NULL,
    "Location" text    NOT NULL,
    CONSTRAINT "pk_Address" PRIMARY KEY (
                                         "id"
        )
);

CREATE TABLE "Hall"
(
    "id"     int     NOT NULL,
    "Name"   varchar NOT NULL,
    "Cinema" int     NOT NULL,
    CONSTRAINT "pk_Hall" PRIMARY KEY (
                                      "id"
        )
);

CREATE TABLE "Place"
(
    "id"            int      NOT NULL,
    "Row"           smallint NOT NULL,
    "Number"        smallint NOT NULL,
    "Hall"          int      NOT NULL,
    "PriceModifier" smallint NOT NULL,
    CONSTRAINT "pk_Place" PRIMARY KEY (
                                       "id"
        )
);

CREATE TABLE "Client"
(
    "id"     int     NOT NULL,
    "E-mail" varchar NOT NULL,
    "Phone"  varchar DEFAULT NULL,
    CONSTRAINT "pk_Client" PRIMARY KEY (
                                        "id"
        )
);

CREATE TABLE "Movie"
(
    "id"   int     NOT NULL,
    "Name" varchar NOT NULL,
    CONSTRAINT "pk_Movie" PRIMARY KEY (
                                       "id"
        )
);

CREATE TABLE "Schedule"
(
    "id"        int      NOT NULL,
    "Date"      date     NOT NULL,
    "Time"      time     NOT NULL,
    "Hall"      int      NOT NULL,
    "Movie"     int      NOT NULL,
    "BasePrice" smallint NOT NULL,
    CONSTRAINT "pk_Schedule" PRIMARY KEY (
                                          "id"
        )
);

CREATE TABLE "Ticket"
(
    "id"           int      NOT NULL,
    "Client"       int      NOT NULL,
    "Price"        smallint NOT NULL,
    "Place"        int      NOT NULL,
    "Schedule"     int      NOT NULL,
    "PurchaseTime" timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT "pk_Ticket" PRIMARY KEY (
                                        "id"
        )
);

ALTER TABLE "Cinema"
    ADD CONSTRAINT "fk_Cinema_Address" FOREIGN KEY ("Address")
        REFERENCES "Address" ("id");

ALTER TABLE "Hall"
    ADD CONSTRAINT "fk_Hall_Cinema" FOREIGN KEY ("Cinema")
        REFERENCES "Cinema" ("id");

ALTER TABLE "Place"
    ADD CONSTRAINT "fk_Place_Hall" FOREIGN KEY ("Hall")
        REFERENCES "Hall" ("id");

ALTER TABLE "Schedule"
    ADD CONSTRAINT "fk_Schedule_Hall" FOREIGN KEY ("Hall")
        REFERENCES "Hall" ("id");

ALTER TABLE "Schedule"
    ADD CONSTRAINT "fk_Schedule_Movie" FOREIGN KEY ("Movie")
        REFERENCES "Movie" ("id");

ALTER TABLE "Ticket"
    ADD CONSTRAINT "fk_Ticket_Client" FOREIGN KEY ("Client")
        REFERENCES "Client" ("id");

ALTER TABLE "Ticket"
    ADD CONSTRAINT "fk_Ticket_Place" FOREIGN KEY ("Place")
        REFERENCES "Place" ("id");

ALTER TABLE "Ticket"
    ADD CONSTRAINT "fk_Ticket_Schedule" FOREIGN KEY ("Schedule")
        REFERENCES "Schedule" ("id");