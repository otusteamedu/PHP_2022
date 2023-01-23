<?php

/**
 * Create Info table
 */

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateInfoTable extends AbstractMigration
{
    /**
     * Up
     * @return void
     */
    public function up(): void
    {
        $sql = "CREATE TABLE `bot_info` (
                `id` INT(11) NOT NULL AUTO_INCREMENT  COMMENT 'PK',
                `section` varchar(255) UNIQUE  COMMENT 'Наименование инфо-секции',
                `text` TEXT COMMENT 'Инфо-текст',
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
        $sql = "DROP TABLE `bot_info`";
        $this->execute($sql);
    }
}
