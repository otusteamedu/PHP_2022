CREATE VIEW current_and_future_tasks AS
    SELECT
        move_entity_1.name as film, move_attribute.name as current_tasks, move_entity_2.future_tasks as future_tasks_after_20_days
    FROM
        move_entity AS move_entity_1
            JOIN move_value ON
                move_entity_1.id=move_value.move_entity_id
            JOIN move_attribute ON
                move_attribute.id=move_value.move_attribute_id
            JOIN (
                SELECT
                    move_entity.name as film, move_attribute.name as future_tasks
                FROM
                    move_entity
                        JOIN move_value ON
                            move_entity.id=move_value.move_entity_id
                        JOIN move_attribute ON
                            move_attribute.id=move_value.move_attribute_id
                WHERE
                    move_value.value_timestamp=CURRENT_DATE+INTERVAL '20 days'
        ) move_entity_2 ON move_entity_1.name = move_entity_2.film
    WHERE
        move_value.value_timestamp=CURRENT_DATE
;