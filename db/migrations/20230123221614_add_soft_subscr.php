<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddSoftSubscr extends AbstractMigration
{
    /**
     * Up
     * @return void
     */
    public function up(): void
    {
        $sql = "ALTER TABLE `bot_subscribers` 
                ADD `is_active` INT(1) NOT NULL DEFAULT 1";
        $this->execute($sql);
    }

    /**
     * Down
     * @return void
     */
    public function down(): void
    {
        $sql = "ALTER TABLE `bot_subscribers` DROP COLUMN `is_active`;";
        $this->execute($sql);
    }
}
