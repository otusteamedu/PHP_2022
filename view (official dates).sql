create view "official_dates" as
	select f."Title" as "Film", a."Title" as "Event", av."Date"
		from "films" f, "attribute_values" av, "attributes" a, "attribute_types" at2
		where av."Film_ID" = f."ID"
			and a."ID" = av."Attribute_ID"
			and (av."Attribute_ID" = 10 or av."Attribute_ID" = 11)
		group by f."Title", a."Title", av."Date" 
		order by f."Title", av."Date";

select * from "official_dates";