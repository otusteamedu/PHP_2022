create or replace view "tickets_sales_start_date" as
	select m."name", mva1."value_date" as "current tasks", mva2."value_date" as "after 20 days"
	from movie m
	left join movie_attribute_value mva1 on m."id" = mva1."movie_id"
	and mva1.value_date = current_date
	and mva1.attribute_id = 10
	left join movie_attribute_value mva2 on m."id" = mva2."movie_id"
	and mva2.value_date = current_date + interval '20 day'
	and mva2.attribute_id = 10;

select * from "tickets_sales_start_date";