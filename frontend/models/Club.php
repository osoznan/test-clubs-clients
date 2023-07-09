<?php

namespace frontend\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Club model
 */
class Club extends Model
{

    public static function tableName(): string
    {
        return '{{%club}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules(): array
    {
        return [
            [['name', 'address'], 'safe'],
            [['name', 'address'], 'required'],
            ['name', 'string', 'min' => 2, 'max' => 100],
            [['name', 'address'], 'trim'],
            ['name', 'unique'],
            ['address', 'string', 'max' => 200]
        ];
    }

    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'name' => 'Название',
            'address' => 'Адрес',
        ]);
    }

    public function getId(): int
    {
        return $this->getPrimaryKey();
    }

}
