<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Department extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'code', 'contact'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название отдела',
            'code' => 'Код отдела',
            'contact' => 'Контакт',
        ];
    }

    public static function getDepartmentList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }

    public static function tableName(): string
    {
        return 'department';
    }
}