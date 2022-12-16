CREATE VIEW movies_events AS
SELECT m."Name"          AS movie,
       m_attr."Name"     AS event,
       attr_date."Value" AS date
FROM "Movie" AS m
         INNER JOIN "MovieAttributeValue" AS m_attr_val on m.id = m_attr_val."Movie"
         INNER JOIN "MovieAttribute" AS m_attr on m_attr_val."MovieAttribute" = m_attr.id
         INNER JOIN "MovieAttributeType" AS m_attr_type on m_attr_type.id = m_attr."MovieAttributeType",
     "AttributeValueDate" AS attr_date
WHERE m_attr_type."Type" = 'date'
  AND m_attr_val."ValueId" = attr_date.id
  AND (CURRENT_DATE = attr_date."Value"
    OR attr_date."Value" = CURRENT_DATE + 20) ORDER BY date ASC;


SELECT *
FROM movies_events;

DROP VIEW movies_events;