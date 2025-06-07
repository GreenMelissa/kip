<?php

namespace app\models;

use yii\db\ActiveRecord;

class Attachment extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%attachment}}';
    }
}