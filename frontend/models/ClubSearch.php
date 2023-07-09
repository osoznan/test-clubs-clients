<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * Client search model
 *
 * @property string name
 * @property string $showDeleted
 */
class ClubSearch extends Club
{
    public $showDeleted;

    public static function tableName(): string
    {
        return '{{%club}}';
    }

    public function rules(): array {
        return array_merge(parent::rules(), [
            ['showDeleted', 'safe']
        ]);
    }

    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'showDeleted' => 'Отображать архивные'
        ]);
    }

    public function search(): ActiveQuery {
        $query = $this->findWithDeleted();

        $query->filterWhere(['like', 'name', $this->name]);

        if (!$this->showDeleted) {
            $query->andWhere('deleted_at IS NULL');
        }

        return $query;
    }

}
