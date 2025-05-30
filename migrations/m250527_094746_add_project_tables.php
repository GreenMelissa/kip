<?php

use yii\db\Migration;

class m250527_094746_add_project_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('department', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addColumn('user', 'department_id', $this->integer());

        $this->addForeignKey('fk_user_department', 'user', 'department_id', 'department', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('attachment', [
            'id' => $this->primaryKey(),
            'filename' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_user_attachment', 'attachment', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_task_attachment', 'attachment', 'task_id', 'task', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('attachment');
        $this->dropColumn('user', 'department_id');
        $this->dropTable('department');
    }
}
