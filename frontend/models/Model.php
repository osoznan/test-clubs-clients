<?php

namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * Base class for Club and Client models
 */
class Model extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'created_at' => 'Время создания'
        ];
    }

    public function beforeSave($insert)
    {
        parent::beforeSave($insert);

        if ($insert) {
            $this->user_created_at = \Yii::$app->user->identity->getId();
        }

        $this->user_updated_at = \Yii::$app->user->identity->getId();

        return true;
    }

    public function delete()
    {
        $this->user_deleted_at = \Yii::$app->user->identity->getId();
        $this->deleted_at = time();

        $this->update();
    }

    public static function find() {
        return (new Query(static::class))->activeOnly();
    }

    public static function findWithDeleted() {
        return (new Query(static::class));
    }

}
