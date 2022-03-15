create view "official_dates" as
	select f."Title" as "Film", a."Title" as "Event", av."Date"
		from "films" f, "attribute_values" av, "attributes" a, "attribute_types" at2
		where av."Film_ID" = f."ID"
			and a."ID" = av."Attribute_ID"
			and at2."ID" = a."Attribute_Type"
			and at2."ID" = 4;
			
select * from "official_dates";