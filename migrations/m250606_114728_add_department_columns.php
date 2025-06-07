<?php

use yii\db\Migration;

class m250606_114728_add_department_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('department', 'code', $this->string());
        $this->addColumn('department', 'contact', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('department', 'code');
        $this->dropColumn('department', 'contact');
    }
}
