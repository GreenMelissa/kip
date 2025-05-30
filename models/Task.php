<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Task extends ActiveRecord
{
    public const STATUS_ACTIVE = 0;
    public const STATUS_EXPIRED = 1;

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['ldap_uid', 'name', 'status'], 'required'],
            ['active_until', 'date', 'format' => 'yyyy-MM-dd'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_EXPIRED]],
            ['name', 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'integer'],
            [['description', 'comment'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Заголовок',
            'status' => 'Статус',
            'ldap_uid' => 'Пользователь LDAP',
            'active_until' => 'Срок',
            'description' => 'Описание',
            'comment' => 'Комментарий',
        ];
    }

    public static function tableName(): string
    {
        return 'task';
    }
}