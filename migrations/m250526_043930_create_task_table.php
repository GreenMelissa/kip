<?php

use app\models\Task;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m250526_043930_create_task_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'ldap_uid' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'status' => $this->integer()->defaultValue(Task::STATUS_ACTIVE),
            'active_until' => $this->date(),
            'comment' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
