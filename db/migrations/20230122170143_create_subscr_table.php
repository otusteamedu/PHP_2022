<?php

/**
 * Create Subscribers table
 */

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSubscrTable extends AbstractMigration
{
    /**
     * Up
     * @return void
     */
    public function up(): void
    {
        $sql = "CREATE TABLE `bot_subscribers` (
                `id` INT(11) NOT NULL AUTO_INCREMENT  COMMENT 'PK',
                `userid` INT(11) NOT NULL UNIQUE  COMMENT 'ИД юзера',
                `username` varchar(255) UNIQUE  COMMENT 'Логин юзера',
                `subscr_date` DATETIME COMMENT 'Дата подписки',
                PRIMARY KEY (`id`)
                );";
        $this->execute($sql);
    }

    /**
     * Down
     * @return void
     */
    public function down(): void
    {
        $sql = "DROP TABLE `bot_subscribers`";
        $this->execute($sql);
    }
}
