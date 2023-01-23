<?php

/**
 * First migration:
 * create messages table
 */

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitDb extends AbstractMigration
{
    /**
     * Do migration
     * @return void
     */
    public function up()
    {
        $sql = "CREATE TABLE `bot_messages` (
                  `id` int(11) NOT NULL COMMENT 'Message id (PK)',
                  `send_time` DATETIME NOT NULL COMMENT 'Message sending dateTime',
                  `text` TEXT NOT NULL COMMENT 'Message text',
                  `chat_id` int(11) NOT NULL COMMENT 'Chat id',
                  `from_username` varchar(255) NULL COMMENT 'Message sender userName',
                  `from_userid` INT(11) NULL COMMENT 'Message sender userId',
                  `json` TEXT NULL COMMENT 'Message in json format'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->execute($sql);

        $sql = "ALTER TABLE `bot_messages`
                ADD PRIMARY KEY (`id`);";
        $this->execute($sql);

        $sql = "ALTER TABLE `bot_messages`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
        $this->execute($sql);
    }

    /**
     * Rollback
     * @return void
     */
    public function down()
    {
        $sql = "DROP TABLE `bot_messages`;";
        $this->execute($sql);
    }
}
