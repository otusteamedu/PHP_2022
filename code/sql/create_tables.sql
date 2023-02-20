CREATE TABLE hall (hall_id smallserial NOT NULL, name VARCHAR(20) NOT NULL, rate numeric, seats_number smallint, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(hall_id));
CREATE TABLE movie (movie_id serial NOT NULL, name VARCHAR(256) NOT NULL, price numeric, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(movie_id));
/*
В каждом зале места делятся на зоны по стоимости , rate - коэффециент отличия от базовой стоимости session.price
*/
CREATE TABLE zone (zone_id smallserial NOT NULL, name VARCHAR(20) NOT NULL, rate real,  created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(zone_id));
/* Стоимость каждого места в каждом зале определяется по zone.rate */
CREATE TABLE place (place_id serial NOT NULL, zone_id smallint NOT NULL, hall_id smallint NOT NULL,  number integer,   created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(place_id));
/*  В session  фиксируется базовая стоимость сеанса(session.price), которая зависит от  фильма, зала, дня, времени. А через зону опрелеляется разница в стоимости места    */
CREATE TABLE session (session_id serial NOT NULL, hall_id smallint NOT NULL,
                      movie_id integer NOT NULL,
                      days_type_id  smallint NULL,
                      started_at  TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                      price numeric,
                      created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(session_id));


CREATE TABLE ticket (ticket_id serial NOT NULL, place_id integer NOT NULL, session_id integer NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(ticket_id));

CREATE TABLE time_type(time_type_id smallserial NOT NULL, name VARCHAR(20) NOT NULL, rate numeric,  minTime time, maxTime time,   created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(time_type_id));
CREATE TABLE days_type(days_type_id smallserial NOT NULL, name VARCHAR(20) NOT NULL, rate numeric,  created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(days_type_id));



ALTER TABLE place ADD CONSTRAINT FK__place__zone_id FOREIGN KEY (zone_id) REFERENCES zone (zone_id)  NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE place ADD CONSTRAINT FK__place__hall_id FOREIGN KEY (hall_id) REFERENCES hall (hall_id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE session ADD CONSTRAINT FK__session__movie_id FOREIGN KEY (movie_id) REFERENCES movie (movie_id)  NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE session ADD CONSTRAINT FK__session__hall_id FOREIGN KEY (hall_id) REFERENCES hall (hall_id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ticket ADD CONSTRAINT FK__ticket__session_id FOREIGN KEY (session_id) REFERENCES session (session_id)  NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ticket ADD CONSTRAINT FK__ticket__place_id FOREIGN KEY (place_id) REFERENCES place (place_id) NOT DEFERRABLE INITIALLY IMMEDIATE;

/*SQL для нахождения самого прибыльного фильма*/
select distinct m.name, sum(s.price * z.rate)
from ticket t
inner join place p on p.place_id = t.place_id
inner join session s on s.session_id = t.session_id
inner join zone z on z.zone_id = p.zone_id
inner join movie m on m.movie_id = s.movie_id
group by m.name
order by sum(s.price * z.rate) desc
limit 1;

CREATE TABLE request_status(request_status_id smallint NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(request_status_id));
CREATE TABLE request_type(request_type_id smallint NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(request_type_id));
CREATE TABLE "user" (user_id smallserial NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(user_id));
CREATE TABLE request (request_id serial NOT NULL, user_id integer NOT NULL, request_type_id integer NOT NULL, request_status_id integer NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(request_id));
