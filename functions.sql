--random_between function
create function random_between(low integer, high integer) returns integer
    strict
    language plpgsql
as
$$
BEGIN
    RETURN floor(random() * (high - low + 1) + low);
END;
$$;

alter function random_between(integer, integer) owner to root;

--random string function
create function random_string(length integer) returns text
    language plpgsql
as
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
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
$$;

alter function random_string(integer) owner to root;
