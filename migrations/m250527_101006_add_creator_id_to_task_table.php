<?php

use yii\db\Migration;

class m250527_101006_add_creator_id_to_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task', 'creator_id', $this->integer());
        $this->addForeignKey('fk_task_user', 'task', 'creator_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task', 'creator_id');
    }
}
