<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * Общий функционал для таблиц Club и Client
 */
class Query extends ActiveQuery {

    // показ неудалённых элементов
    public function activeOnly(): ActiveQuery {
        return $this->where('deleted_at IS NULL');
    }

}