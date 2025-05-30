<?php

use yii\db\Migration;

class m250526_085339_add_email_to_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'email', 'string');
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'email');
    }
}
