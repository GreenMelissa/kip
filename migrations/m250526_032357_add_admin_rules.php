<?php

use app\models\User;
use yii\db\Migration;

class m250526_032357_add_admin_rules extends Migration
{
    public function safeUp()
    {
        $admin = User::find()->where(['username' => 'admin'])->one();
        \Yii::$app->db->createCommand()->insert('auth_assignment', [
            'item_name' => 'admin',
            'user_id' => $admin->id,
            'created_at' => time(),
        ])->execute();
    }

    public function safeDown()
    {
        \Yii::$app->db->createCommand()->delete('auth_assignment')->execute();
    }
}
