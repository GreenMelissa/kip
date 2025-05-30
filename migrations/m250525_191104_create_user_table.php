<?php

use app\models\User;
use yii\db\Migration;

class m250525_191104_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'display_name' => $this->string(),
        ]);

        \Yii::$app->db->createCommand()->insert('user', [
            'username' => 'admin',
            'display_name' => 'Администратор системы КИП',
        ])->execute();

        \Yii::$app->db->createCommand()->insert('auth_item', [
            'name' => User::ROLE_ADMIN,
            'type' => 1,
            'description' => 'Администратор',
        ])->execute();

        \Yii::$app->db->createCommand()->insert('auth_item', [
            'name' => 'user',
            'type' => 1,
            'description' => 'Пользователь',
        ])->execute();
    }

    public function safeDown()
    {
        $this->dropTable('user');
        \Yii::$app->db->createCommand()->delete('auth_item')->execute();
    }
}
