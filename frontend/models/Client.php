<?php

namespace frontend\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Client model
 *
 * @property string name
 * @property string sex
 * @property string birth_date
 * @property string clubs
 */
class Client extends Model
{

    public static function tableName(): string
    {
        return '{{%client}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['name', 'sex', 'birth_date', 'clubs'], 'safe'],
            ['name', 'unique'],
            [['name', 'sex', 'birth_date'], 'required'],
            //  ['name', 'regex', '\w+ \w+ \w*'],
            ['name', 'string', 'min' => 3, 'max' => 100],
            [['name', 'birth_date'], 'trim'],
            ['birth_date', 'date', 'format' => 'php:Y-m-d']
        ]);
    }

    public function attributeLabels()
    {
        return [
            'name' => 'ФИО',
            'sex' => 'Пол',
            'birth_date' => 'Дата рождения',
            'clubs' => 'Клубы',
        ];
    }

    // список клубов сохраняется в формат строки
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->clubs = is_array($this->clubs) ? join(',', $this->clubs) : $this->clubs;

        return true;
    }

    public function getId(): int
    {
        return $this->getPrimaryKey();
    }

    public function getClubList() {
        return is_string($this->clubs) ? explode(',', $this->clubs) : $this->clubs;
    }

    // коль не делалась 3-я сущность (производная таблица client_club),
    // то присоединение данных по клубам клиентов делаем след. образом
    public function attachClubsData($data): array {
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
