CREATE VIEW movies_events AS
SELECT m."Name"          AS movie,
       m_attr."Name"     AS event,
       m_attr_val."ValueDate" AS date
FROM "Movie" AS m
         INNER JOIN "MovieAttributeValue" AS m_attr_val on m.id = m_attr_val."Movie"
         INNER JOIN "MovieAttribute" AS m_attr on m_attr_val."MovieAttribute" = m_attr.id
         INNER JOIN "MovieAttributeType" AS m_attr_type on m_attr_type.id = m_attr."MovieAttributeType"
WHERE m_attr_type."Type" = 'date'
  AND (CURRENT_DATE = m_attr_val."ValueDate"
    OR m_attr_val."ValueDate" = CURRENT_DATE + 20) ORDER BY date ASC;


SELECT *
FROM movies_events;