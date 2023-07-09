<?php

namespace frontend\models;

trait CrudTimeAndUser {

    public function beforeSave($insert)
    {
        parent::beforeSave($insert);

        if ($insert) {
            $this->user_created_at = \Yii::$app->user->identity->getId();
        }

        $this->user_updated_at = \Yii::$app->user->identity->getId();

        return true;
    }

    public function beforeDelete()
    {
        parent::afterDelete();
        $this->user_deleted_at = \Yii::$app->user->identity->getId();
        $this->deleted_at = date('Y-m-d h:i:s');
    }

}