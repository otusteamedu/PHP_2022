-- Otus homeWork #11 (cinema DB, extended version)
-- applied functions 

-- random string generator
create or replace function random_string(length integer) returns text as
$$
declare
    chars  text[]  := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text    := '';
    i      integer := 0;
begin
    if length < 0 then
        raise exception 'Error: Given length cannot be less than 0';
    end if;
    for i in 1..length
        loop
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        end loop;
    return result;
end;
$$ language plpgsql;

-- random num generator
create or replace function random_integer(low integer, high integer) returns integer as
$$
begin
    return floor(random() * (high - low + 1) + low);
end;
$$ language plpgsql;

-- random timestamp generator
create or replace function random_timestamp() returns timestamp as
$$
begin
    if random() < 0.5 then
        return now() - random() * 30 * 24 * interval '1 hour';
    end if;

    return now() + random() * 30 * 24 * interval '1 hour';
end;
$$ language plpgsql;