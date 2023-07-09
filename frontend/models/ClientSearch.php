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
        return [
            ['name', 'trim'],
            [['birthTo', 'birthFrom'], 'date', 'format' => 'php:Y-m-d'],
            ['sex', 'safe']
        ];
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

    // коль не делалась 3-я сущность (производная таблица client_club),
    // то присоединим данные клубов клиентов таким образом
    protected function attachClubsData($data): array {
        $ids = [];
        foreach ($data as $client) {
            $ids = array_merge($ids, $client['clubs'] ? explode(',', $client['clubs']) : []);
        }

        $ids = array_unique($ids);

        $clubs = Club::find()->where(['id' => $ids])
            ->asArray()->indexBy('id')->all();

        foreach ($data as $key => $client) {
            $clientClubs = [];
            $clientClubsArray = isset($client['clubs']) ? explode(',', $client['clubs']) : [];
            foreach ($clientClubsArray as $clubId) {
                if (isset($clubs[$clubId])) {
                    $clientClubs[] = $clubs[$clubId];
                }
            }
            $data[$key]['clubs'] = $clientClubs;
        }

        return $data;
    }

}
