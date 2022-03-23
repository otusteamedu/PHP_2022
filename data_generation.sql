CREATE OR REPLACE FUNCTION random_string(length integer) returns text as
$$
declare
  chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
begin
  if length < 0 then
    raise exception 'Given length cannot be less than 0';
  end if;
  for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
  end loop;
  return result;
end;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION rand_date_time(start_date date, end_date date) RETURNS TIMESTAMP AS
$$
 DECLARE
    interval_days integer;
    random_seconds integer;
    random_dates integer;
    random_date date;
    random_time time;
BEGIN
    interval_days := end_date - start_date;
    random_dates:= trunc(random()*interval_days);
    random_date := start_date + random_dates;
    random_seconds:= trunc(random()*3600*24);
    random_time:=' 00:00:00'::time+(random_seconds || ' second')::INTERVAL;
    RETURN random_date +random_time;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION rand_between(low INT ,high INT) RETURNS INT AS
$$
BEGIN
   RETURN floor(random()* (high-low + 1) + low);
END;
$$ language plpgsql STRICT;

CREATE OR REPLACE FUNCTION rand_film_name() RETURNS TEXT AS
$$
DECLARE
    filmsList text[] := array['Iron Man', 'Avatar', 'Titanic', 'The Avengers'];
BEGIN
   RETURN (filmsList::text[])[ceil(random()*array_length(filmsList::text[], 1))];
END;
$$ language plpgsql STRICT;

CREATE OR REPLACE FUNCTION rand_schedule_day() RETURNS day AS
$$
DECLARE
    schedule text[] := array['monday', 'thuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
BEGIN
   RETURN (schedule::text[])[ceil(random()*array_length(schedule::text[], 1))];
END;
$$ language plpgsql STRICT;

CREATE OR REPLACE FUNCTION rand_schedule_time() RETURNS time AS
$$
DECLARE
    schedule text[] := array['10:00:00', '15:00:00', '20:00:00'];
BEGIN
   RETURN (schedule::text[])[ceil(random()*array_length(schedule::text[], 1))];
END;
$$ language plpgsql STRICT;

-- Insert base data

INSERT INTO halls ("ID", "Title") VALUES
(1, 'Hall 1'),
(2, 'Hall 2'),
(3, 'Hall IMAX'),
(4, 'Hall Dolby ATMOS');

INSERT INTO hall_places ("Hall_ID", "Row", "Count_places") VALUES
(1, 1, 5),
(1, 2, 5),
(1, 3, 5),
(1, 4, 5),
(1, 5, 5),
(2, 1, 10),
(2, 2, 10),
(2, 3, 10),
(2, 4, 10),
(2, 5, 10),
(2, 6, 10),
(2, 7, 10),
(3, 1, 4),
(3, 2, 4),
(3, 3, 4),
(3, 4, 4),
(4, 1, 5),
(4, 2, 5),
(4, 3, 5),
(4, 4, 5);

-- Generate fake data

INSERT INTO films ("ID", "Title", "Duration", "Release_date", "Status")
    select
        gs.id,
        rand_film_name() || ' ' || random_string((1 + random()*30)::integer),
        rand_between(100, 300),
        rand_date_time('2000-01-01', '2022-12-31'),
        'active'
    from generate_series(1, 100000) as gs(id);

INSERT INTO schedule ("ID", "Hall_ID", "Film_ID", "Day", "Time", "Price")
    select
        gs.id,
        rand_between(1, 4),
        rand_between(1, 100000),
        rand_schedule_day(),
        rand_schedule_time(),
        rand_between(200, 600)
    from generate_series(1, 1000000) as gs(id);

INSERT INTO tickets ("ID", "Schedule_ID", "Row_ID", "Place", "Date", "Amount")
    select
        gs.id,
        rand_between(1, 1000000),
        rand_between(1, 7),
        rand_between(1, 10),
        rand_date_time('2022-01-01', '2022-12-31'),
        rand_between(200, 600)
    from generate_series(1, 10000000) as gs(id);
