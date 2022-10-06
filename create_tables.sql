CREATE TABLE IF NOT EXISTS public.film
(
    id_film integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    film_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT "PK_id_film" PRIMARY KEY (id_film)
)

CREATE TABLE IF NOT EXISTS public.film_attr_type
(
    id_type_attr integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    attr_type_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT "PK_id_type_attr" PRIMARY KEY (id_type_attr),
    CONSTRAINT "UNIQUE_attr_type_name" UNIQUE (attr_type_name)
        INCLUDE(attr_type_name)
)

CREATE TABLE IF NOT EXISTS public.film_attr
(
    "id_attr int" integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    id_type_attr integer NOT NULL,
    attr_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT "PK_id_attr" PRIMARY KEY ("id_attr int"),
    CONSTRAINT "UNIQUE_attr_name" UNIQUE (attr_name)
        INCLUDE(attr_name),
    CONSTRAINT "FK1_id_type_attr" FOREIGN KEY (id_type_attr)
        REFERENCES public.film_attr_type (id_type_attr) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
        NOT VALID
)

CREATE TABLE IF NOT EXISTS public.film_values
(
    id_val integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    id_film integer NOT NULL,
    id_attr integer NOT NULL,
    val_int integer,
    val_char character varying COLLATE pg_catalog."default",
    val_date date,
    val_boolean boolean,
    "val_float " numeric,
    CONSTRAINT "PK_id_val" PRIMARY KEY (id_val),
    CONSTRAINT "FK1_id_film" FOREIGN KEY (id_film)
        REFERENCES public.film (id_film) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT "FK2_id_attr" FOREIGN KEY (id_attr)
        REFERENCES public.film_attr ("id_attr int") MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)


CREATE UNIQUE INDEX index_film_values
ON film_values(id_film, id_attr);