CREATE
OR REPLACE FUNCTION random_string(str_len integer) RETURNS text AS
$$ DECLARE
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i integer := 0;
    BEGIN
        if str_len < 0 then
            raise exception 'Given `str_len` can`t be less than 0';
        end if;
        for i in 1..str_len loop
            result := result || chars[1+random()*(array_length(chars, 1)-1)];
        end loop;
        return result;
    END;
$$ LANGUAGE plpgsql;