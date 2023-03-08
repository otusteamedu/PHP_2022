<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserTableMigrations extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        // create the table
        $table = $this->table(tableName: 'users');

        $table->addColumn(columnName: 'username', type: 'string', options: ['null' => false])
            ->addColumn(columnName: 'password', type: 'string', options: ['null' => false])
            ->addColumn(columnName: 'api_token', type: 'string', options: ['null' => true])
            ->addColumn(columnName: 'scopes', type: 'json', options: ['null' => false])
            ->addColumn(columnName: 'created_at', type: 'datetime', options: ['null' => false])
            ->addColumn(columnName: 'updated_at', type: 'datetime', options: ['null' => false])
            ->addIndex(['username'], ['unique' => true])
            ->create();
    }
}
