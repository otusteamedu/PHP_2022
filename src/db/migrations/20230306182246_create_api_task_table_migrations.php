<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CreateApiTaskTableMigrations extends AbstractMigration
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
        $table = $this->table(tableName: 'api_tasks', options: ['id' => false]);

        $table->addColumn(columnName: 'uuid', type: 'string', options: ['null' => false])
            ->addColumn(columnName: 'status', type: 'string', options: ['null' => false])
            ->addColumn(
                columnName: 'result',
                type: 'text',
                options: [
                    'null' => true,
                    'limit' => MysqlAdapter::TEXT_MEDIUM,
                    ]
            )
            ->addColumn(columnName: 'created_at', type: 'datetime', options: ['null' => false])
            ->addColumn(columnName: 'updated_at', type: 'datetime', options: ['null' => false])
            ->addIndex(['uuid'], ['unique' => true])
            ->create();
    }
}
