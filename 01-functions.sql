CREATE OR REPLACE function random_string(length integer) returns text as
$$
declare
    chars text[] := '{a,b,c,d,e,f,g}';
    result text := '';
    i integer := 0;
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


CREATE OR REPLACE function random_int(zeros int)
    returns int language plpgsql as $$
BEGIN
    return trunc(random() * concat('1', repeat('0', zeros + 1))::int);
END
$$;

CREATE OR REPLACE FUNCTION random_between(low DOUBLE PRECISION, high DOUBLE PRECISION)
    RETURNS DOUBLE PRECISION AS
$$
BEGIN
    RETURN round(random() * (high - low) + low);
END;
$$ language 'plpgsql' STRICT;