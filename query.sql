-- List all values by film id = 2

select "p.A".name,
       coalesce(
               "p.V".value_integer::text,
               "p.V".value_text::text,
               "p.V".value_boolean::text,
               "p.V".value_float::text,
               "p.V".value_date::text
           ) as value,
       "p.AT".name
from "public.Attributes" "p.A"
         inner join "public.Values" "p.V" on "p.A".id = "p.V".attribute_id
         inner join "public.AttributeTypes" "p.AT" on "p.A".type = "p.AT".id
where "p.V".film_id = 2;


-- Films on Date
-- Просто как пример вывести параметр определенной даты. Указана дата Премьеры в России

select "p.F".name,
       "p.A".name,
       coalesce(
               "p.V".value_integer::text,
               "p.V".value_text::text,
               "p.V".value_boolean::text,
               "p.V".value_float::text,
               "p.V".value_date::text
           ) as value,
       "p.AT".name
from "public.Attributes" "p.A"
         inner join "public.Values" "p.V" on "p.A".id = "p.V".attribute_id
         inner join "public.AttributeTypes" "p.AT" on "p.A".type = "p.AT".id
         inner join "public.Films" "p.F" on "p.V".film_id = "p.F".id
where "p.A".id = 4
  AND "p.V".value_date BETWEEN '2013-12-10' AND '2013-12-10';