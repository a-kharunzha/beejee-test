<?php


use Phinx\Migration\AbstractMigration;

class AddTaskTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('tasks');
        $table
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('text', 'text')
            ->addColumn('status', 'boolean', ['default' => false])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
