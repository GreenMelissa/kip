<?php

use yii\db\Migration;

class m250528_094707_add_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task_history', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_task_history_user', 'task_history', 'user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk_task_history_task', 'task_history', 'task_id', 'task', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task_history');
    }
}
