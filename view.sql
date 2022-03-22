-- Создаем view
CREATE VIEW film_attribute AS  select "p.F".name film_name,
                                      "p.A".name attribute_name,
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
                                        inner join "public.Films" "p.F" on "p.V".film_id = "p.F".id;


-- Вывод всего что есть во view

SELECT * FROM film_attribute;

-- Вывод согласно определенной дате

SELECT * FROM film_attribute
WHERE film_attribute.attribute_name = 'Премьера в России'
  AND film_attribute.value BETWEEN '2013-12-10' AND '2013-12-10';