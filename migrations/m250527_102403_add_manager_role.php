<?php

use yii\db\Migration;
use app\models\User;

class m250527_102403_add_manager_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \Yii::$app->db->createCommand()->insert('auth_item', [
            'name' => User::ROLE_MANAGER,
            'type' => 1,
            'description' => 'Руководитель',
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250527_102403_add_manager_role cannot be reverted.\n";

        return false;
    }
}
