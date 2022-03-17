create view "tasks" as		
	select f."Title" as "Film", at2."Title" as "Actual tasks", at3."Title" as "Future tasks (via 20 days)" from "films" f
	left join "attribute_values" av on av."Film_ID" = f."ID"
		and av."Date" = current_date
		and (av."Attribute_ID" = 10 or av."Attribute_ID" = 11)
	left join "attributes" at2 on at2."ID" = av."Attribute_ID"
	left join "attribute_values" av2 on av2."Film_ID" = f."ID"
		and av2."Date" = current_date + interval '20 day'
		and (av2."Attribute_ID" = 10 or av2."Attribute_ID" = 11)
	left join "attributes" at3 on at3."ID" = av2."Attribute_ID";

select * from "tasks";
