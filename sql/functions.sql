/* return random string consisting of count 'length' symbols */
CREATE
    OR REPLACE FUNCTION random_string(length INT) RETURNS text AS
$$
DECLARE
    chars  text[]  := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text    := '';
    i      INT := 0;
BEGIN
    if
        LENGTH < 0 THEN
        raise EXCEPTION 'Given length cannot be less than 0';
    END if;
    FOR i IN 1..length
        loop
            RESULT := RESULT || chars[1 + random() * (array_length(chars, 1) - 1)];
        END loop;
    RETURN result;
END;
$$
    LANGUAGE plpgsql;


/* return random type from 'types' array */
CREATE
    OR REPLACE FUNCTION random_type() RETURNS text AS
$$
DECLARE
    types text[] := '{int, bool, date, string, float}';
BEGIN
    RETURN types[1 + random() * (array_length(types, 1) - 1)];
END;
$$
    LANGUAGE plpgsql;



/* return INT value from range of number */
CREATE
    OR REPLACE FUNCTION random_range(min INT, max INT) RETURNS INT AS
$$
BEGIN
    RETURN round(random() * (max - min) + min);
END;
$$
    language plpgsql;