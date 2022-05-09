create or replace view "sevices_dates" as
	select m."name", ma."name" as "service date name", mav."value_date" as "sevice date"
	from movie m
	left join movie_attribute_value mav on m."id" = mav."movie_id"
	left join movie_attribute ma ON ma."id" = mav."attribute_id"
	left join movie_attribute_type mat on ma."type_id" = mat."id"
	where mat."type_name" = 'Дата'
	order by mav."value_date";

select * from "sevices_dates";