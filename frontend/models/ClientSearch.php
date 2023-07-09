<?php

namespace frontend\models;

/**
 * Client search model
 *
 * @property string name
 * @property string birthFrom
 * @property string birthTo
 */
class ClientSearch extends Client
{
    public $birthFrom;
    public $birthTo;

    public static function tableName(): string
    {
        return '{{%client}}';
    }

    public function rules(): array {
        return array_merge(parent::rules(), [
            [['birthTo', 'birthFrom'], 'date', 'format' => 'php:Y-m-d'],
        ]);
    }

    public function attributeLabels(): array {
        return array_merge(parent::attributeLabels(), [
            'birthFrom' => 'От даты рождения',
            'birthTo' => 'До даты рождения',
        ]);
    }

    public function search() {
        $query = $this->find();

        $query->filterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['sex' => $this->sex]);
        $query->andFilterWhere(['>=', 'birth_date', $this->birthFrom]);
        $query->andFilterWhere(['<=', 'birth_date', $this->birthTo]);

        $data = $query->indexBy('id')->asArray()->all();

        $data = $this->attachClubsData($data);

        return $data;
    }

}
