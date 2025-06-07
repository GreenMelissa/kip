<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Task extends ActiveRecord
{
    public const STATUS_ACTIVE = 0;
    public const STATUS_EXPIRED = 1;
    public const STATUS_READY = 2;
    public const STATUS_REQUEST_FOR_PROLONGE = 3;

    /**
     * @var UploadedFile[]
     */
    public $files;

    public function load($data, $formName = null)
    {
        $this->files = UploadedFile::getInstances($this, 'files');
        return parent::load($data, $formName);
    }

    public function beforeSave($insert)
    {
        if ($this->isAttributeChanged('status') && !$insert) {
            $taskHistory = new TaskHistory();
            $taskHistory->status = $this->getOldAttribute('status');
            $taskHistory->user_id = \Yii::$app->user->id;
            $taskHistory->task_id = $this->id;
            $taskHistory->save();
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->files) {
            $this->upload();
        }
    }

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
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_EXPIRED, self::STATUS_READY, self::STATUS_REQUEST_FOR_PROLONGE]],
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
            'ldap_uid' => 'Исполнитель',
            'active_until' => 'Срок',
            'description' => 'Описание',
            'comment' => 'Комментарий',
            'files' => 'Вложения',
        ];
    }

    public function upload()
    {
        foreach ($this->files as $file) {
            $filename = $file->baseName . '.' . $file->extension;
            $file->saveAs('uploads/' . $filename);
            $attachment = new Attachment();
            $attachment->user_id = Yii::$app->user->id;
            $attachment->task_id = $this->id;
            $attachment->filename = $file->baseName . '.' . $file->extension;
            $attachment->save();
        }
    }

    public static function getStatusList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Активно',
            self::STATUS_EXPIRED => 'Просрочено',
            self::STATUS_READY => 'Исполнено',
            self::STATUS_REQUEST_FOR_PROLONGE => 'Запрос на продление',
        ];
    }

    public function getAttachments()
    {
        return $this->hasMany(Attachment::class, ['task_id' => 'id']);
    }

    public function getHistory()
    {
        return $this->hasMany(TaskHistory::class, ['task_id' => 'id']);
    }

    public static function tableName(): string
    {
        return 'task';
    }
}