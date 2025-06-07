<?php

use yii\db\Migration;

class m250606_140803_change_description extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('task', 'description', $this->text());
        $this->alterColumn('task', 'comment', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250606_140803_change_description cannot be reverted.\n";

        return false;
    }
}
